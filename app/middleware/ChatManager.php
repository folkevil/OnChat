<?php

declare(strict_types=1);

namespace app\middleware;

use app\core\Result;
use app\facade\UserService;
use app\model\ChatMember as ChatMemberModel;
use think\Request;
use think\Response;

/**
 * 聊天管理员中间件（室主或管理员）
 */
class ChatManager
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param \Closure $next
     * @param string $field Request中聊天室的字段名
     * @return Response
     */
    public function handle(Request $request, \Closure $next, string $field = 'id'): Response
    {
        $chatroomId = (int) $request->param($field);
        $userId = UserService::getId();

        $chatMember = ChatMemberModel::where([
            'user_id'     => $userId,
            'chatroom_id' => $chatroomId
        ])->find();

        // 如果不是管理员或者室主
        if (!$chatMember || !in_array($chatMember->role, [ChatMemberModel::ROLE_HOST, ChatMemberModel::ROLE_MANAGE])) {
            return Result::create(Result::CODE_NO_PERMISSION)->toJson();
        }

        return $next($request);
    }
}

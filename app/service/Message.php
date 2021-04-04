<?php

declare(strict_types=1);

namespace app\service;

use HTMLPurifier;
use HTMLPurifier_Config;
use app\core\Result;

use app\util\Str as StrUtil;

class Message
{
    const TYPE_SYSTEM = 0;
    const TYPE_TEXT = 1;
    const TYPE_RICH_TEXT = 2;
    const TYPE_TIPS = 3;
    const TYPE_CHAT_INVITATION = 4;
    const TYPE_IMAGE = 5;

    /** 文本消息最长长度 */
    const TEXT_MSG_MAX_LENGTH = 3000;

    /** 消息过长 */
    const CODE_MSG_LONG  = 1;

    /** 响应消息预定义 */
    const MSG = [
        self::CODE_MSG_LONG  => '文本消息长度过长',
    ];

    public function handle(array $msg): Result
    {
        switch ($msg['type']) {
            case self::TYPE_TEXT:
                $content = $msg['data']['content'];

                if (mb_strlen(StrUtil::trimAll($content), 'utf-8') === 0) {
                    return new Result(Result::CODE_ERROR_PARAM);
                }

                if (mb_strlen($content, 'utf-8') > self::TEXT_MSG_MAX_LENGTH) {
                    return new Result(self::CODE_MSG_LONG, self::MSG[self::CODE_MSG_LONG]);
                }

                $data['content'] = htmlspecialchars($content);
                $msg['data'] = $data;
                break;

            case self::TYPE_RICH_TEXT:
                $html = $msg['data']['html'];
                $text = $msg['data']['text'];

                if (mb_strlen(StrUtil::trimAll($text), 'utf-8') === 0) {
                    return new Result(Result::CODE_ERROR_PARAM);
                }

                if (mb_strlen($text, 'utf-8') > self::TEXT_MSG_MAX_LENGTH) {
                    return new Result(self::CODE_MSG_LONG, self::MSG[self::CODE_MSG_LONG]);
                }

                $config = HTMLPurifier_Config::createDefault();
                // 允许的元素
                $config->set('HTML.AllowedElements', [
                    'p', 'strong', 'em', 'u', 's', 'blockquote',
                    'ol', 'ul', 'li', 'pre', 'br', 'sub', 'sup',
                    'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span'
                ]);
                // 允许的属性
                $config->set('HTML.AllowedAttributes', ['class']);
                // 允许的CLASS
                $config->set('Attr.AllowedClasses', [
                    'ql-indent-1',
                    'ql-indent-2',
                    'ql-indent-3',
                    'ql-indent-4',
                    'ql-indent-5',
                    'ql-indent-6',
                    'ql-indent-7',
                    'ql-indent-8',
                    'ql-align-center',
                    'ql-align-right',
                    'ql-align-justify',
                    'ql-font-serif',
                    'ql-font-monospace',
                    'ql-syntax',
                ]);
                $purifier = new HTMLPurifier($config);

                $data['html'] = $purifier->purify($html);
                $data['text'] = htmlspecialchars($text);

                $msg['data'] = $data;
                break;

            case self::TYPE_CHAT_INVITATION:
                $data['chatroomId'] = $msg['data']['chatroomId'];
                $msg['data'] = $data;
                break;

            case self::TYPE_IMAGE:
                if (!isset($msg['data']['filename'])) {
                    return new Result(Result::CODE_ERROR_PARAM);
                }

                $data['filename'] = $msg['data']['filename'];
                $msg['data'] = $data;
                break;

            default:
                return new Result(Result::CODE_ERROR_PARAM, '未知消息类型');
        }

        return Result::success($msg);
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ChangeRequest; // ★ChangeRequestモデルをuseする

class ReservationResultNotified extends Notification
{
    use Queueable;

    // ▼▼▼ プロパティを2つ追加 ▼▼▼
    /**
     * @var \App\Models\ChangeRequest
     */
    protected $changeRequest;

    /**
     * @var string
     */
    protected $result; // '承認' or '却下'

    /**
     * Create a new notification instance.
     */
    // ▼▼▼ コンストラクタを編集 ▼▼▼
    public function __construct(ChangeRequest $changeRequest, string $result)
    {
        $this->changeRequest = $changeRequest;
        $this->result = $result;
    }

    /**
     * どの媒体で通知するか
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        // ★今回はメールで通知するので、'mail'を返す
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // ▼▼▼ toMailメソッドを編集 ▼▼▼
    public function toMail($notifiable): MailMessage
    {
        $subject = "【EquipHub】予約申請が{$this->result}されました"; // 承認 or 却下
        $greeting = "{$notifiable->name} 様";
        $line1 = "あなたの予約申請が{$this->result}されましたので、お知らせいたします。";
        $line2 = "対象備品: {$this->changeRequest->targetable->name}";

        // payloadから期間を取得
        $payload = json_decode($this->changeRequest->payload_after, true);
        $period = "希望期間: {$payload['start_date']} ~ {$payload['end_date']}";

        $actionText = 'マイ予約一覧を確認する';
        $actionUrl = route('my.reservations.index');

        return (new MailMessage)
                    ->subject($subject)
                    ->greeting($greeting)
                    ->line($line1)
                    ->line($line2)
                    ->line($period) // ★希望期間の行を追加
                    ->action($actionText, $actionUrl)
                    ->line('本メールにご不明な点がございましたら、管理者までお問い合わせください。');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}

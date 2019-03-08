<?php

namespace App\Console\Commands;

use App\Aral\PriceFetcher;
use App\Price;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class UpdateTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send gas price information to Telegram.';

    /**
     * All chats that will receive the information.
     *
     * @var array
     */
    protected $chats = [
        -341401092
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // @Hack maybe don't use count to get the last X relevant rows?
        $typeCount = count(PriceFetcher::TYPES);
        $pricing = Price::orderByDesc('created_at')
            ->limit($typeCount)
            ->get();

        $text = "<b>Huidige benzineprijzen in Elten:</b>\n";

        foreach ($pricing as $price) {
            $text .= $price->name . ' - €' . ($price->price / 100) . "/L \n";
        }

        foreach ($this->chats as $chat) {
            Telegram::sendMessage([
                'chat_id' => $chat,
                'text' => $text,
                'parse_mode' => 'html'
            ]);
        }
    }
}

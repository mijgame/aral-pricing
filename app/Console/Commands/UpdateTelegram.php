<?php

namespace App\Console\Commands;

use App\Stations\PriceFetcher;
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
        -341401092,
        -258376401
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $prices = Price::getLastWeek();
        $toSend = [];

        foreach ($prices as $type) {
            $item = $type->last();

            $toSend[] = [
                'price' => $item->price / 100,
                'name' => $item->product->name,
                'station' => $item->product->station->name
            ];
        }

        $text = "<b>Huidige benzineprijzen in Elten:</b>\n";

        foreach ($toSend as $item) {
            $text .= $item['station'] . ' - ' . $item['name'] . ' - €' . $item['price'] . "/L \n";
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

<?php

use App\pictures;
use App\AuctionSettings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        pictures::truncate();
        AuctionSettings::truncate();

        DB::table('auction_settings')->insert([
            'time' => '15.00'
        ]);

        DB::table('pictures')->insert([
            'name' => 'Портрет доктора Гаше',
            'author' => 'Винсент ван Гог',
            'description' => 'Портрет Поля Гаше, который следил за здоровьем художника на склоне его жизни, с веточкой наперстянки (из которой он приготовлял для художника лечебное снадобье) был продан на аукционе «Christie\'s» 15 мая 1990 года за рекордную сумму 82.5 млн долларов. На протяжении следующих 15 лет картина возглавляла список самых дорогих картин. Покупатель: промышленник Риоеи Сайто (Япония). Вскоре после сделки он был лишен свободы на три года за взяточничество. В этот сложный период жизни Сайто заявил, что попросит кремировать картину вместе с ним и захоронить. Однако, нет данных о том, что это произошло.',
            'start_price' => '82.50',
            'owner' => 'auction',
            'buy_price' => '0.00',
            'release' => '1890',
            'image' => 'Portrait_of_Dr_Gachet.jpg',
            'inAuction' => '1',
        ]);

        DB::table('pictures')->insert([
            'name' => 'ОРАНЖЕВОЕ, КРАСНОЕ, ЖЁЛТОЕ',
            'author' => 'МАРК РОТКО',
            'description' => 'Картина стала не только самой дорогой работой художника русского происхождения, но и самым дорогим произведением послевоенного и современного искусства, проданным на открытых торгах. Прежде всего Ротко известен своими абстрактными картинами, состоящими из нескольких цветовых сегментов.',
            'start_price' => '86.70',
            'owner' => 'auction',
            'buy_price' => '0.00',
            'release' => '1961',
            'image' => 'ORANGE_RED_YELLOW.jpg',
            'inAuction' => '1',
        ]);

        DB::table('pictures')->insert([
            'name' => 'ПОРТРЕТ АДЕЛИ БЛОХ-БАУЭР II',
            'author' => 'ГУСТАВ КЛИМТ',
            'description' => 'Климт — австрийский художник, основоположник модерна в австрийской живописи. Главным предметом его живописи было женское тело, и большинство его работ отличает откровенный эротизм. Адель Блох-Бауэр послужила моделью для целых четырех работ австрийского художника: «Юдифь I», «Юдифь II» и, собственно, два портрета героини под номерами I и II, написанные в 1907 и 1912 годах.',
            'start_price' => '87.90',
            'owner' => 'auction',
            'buy_price' => '0.00',
            'release' => '1912',
            'image' => 'PORTRAIT_OF_ADELIE_BLOCH-BOWER_II.jpg',
            'inAuction' => '1',
        ]);

        DB::table('pictures')->insert([
            'name' => 'ДОРА МААР С КОШКОЙ',
            'author' => 'ПАБЛО ПИКАССО',
            'description' => 'Изображение возлюбленной Пикассо Доры Маар, которая в течение почти десяти лет была его музой, моделью и любовницей. Портрет написан в 1941 году в оккупированном немцами Париже, когда отношения между любовниками уже дали основательную трещину. Позже художник признался, что в период написания картины Дора стала для него «персонификацией войны».',
            'start_price' => '95.20',
            'owner' => 'auction',
            'buy_price' => '0.00',
            'release' => '1941',
            'image' => 'DORA_MAAR_WITH_CAT.jpg',
            'inAuction' => '1',
        ]);

        DB::table('pictures')->insert([
            'name' => 'МАЛЬЧИК С ТРУБКОЙ',
            'author' => 'ПАБЛО ПИКАССО',
            'description' => 'Картина, написанная в общежитии Бато-Лавуар на Монмартре 24-летним художником Пабло Пикассо в 1905 году, в т. н. розовый период его творчества. Она изображает неизвестного мальчика в венке из роз, держащего в левой руке трубку.',
            'start_price' => '104.10',
            'owner' => 'auction',
            'buy_price' => '0.00',
            'release' => '1905',
            'image' => 'BOY_WITH_A_PIPE.jpg',
            'inAuction' => '1',
        ]);

        DB::table('pictures')->insert([
            'name' => 'КРИК',
            'author' => 'ЭДВАРД МУНК',
            'description' => 'Это 4-я картина из серии «Криков» — картин норвежского художника-экспрессиониста Эдварда Мунка. На них изображена кричащая в отчаянии человеческая фигура на фоне кроваво-красного неба и крайне обобщённого пейзажного фона. «Крик» как эмблема экспрессионизма служит своего рода прелюдией к искусству XX века, предвещая ключевые для модернизма темы одиночества, отчаяния и отчуждения.',
            'start_price' => '119.90',
            'owner' => 'auction',
            'buy_price' => '0.00',
            'release' => '1910',
            'image' => 'Scream.jpg',
            'inAuction' => '1',
        ]);

        DB::table('pictures')->insert([
            'name' => 'ОБНАЖЁННАЯ, ЗЕЛЁНЫЕ ЛИСТЬЯ И БЮСТ',
            'author' => 'ПАБЛО ПИКАССО',
            'description' => 'Это одна из знаменитой серии сюрреалистических картин 1932 года, на которых Пабло Пикассо затейливо преобразил свою новую возлюбленную Мари-Терез Вальтер. Серия портретов спящей Мари-Терез как богини секса и желания была выполнена художником втайне от жены, Ольги Хохловой, во время пребывания с подругой в Буажелу под Парижем.',
            'start_price' => '106.50',
            'owner' => 'auction',
            'buy_price' => '0.00',
            'release' => '1932',
            'image' => 'NUDED_GREEN_LEAVES_AND_BUST.jpg',
            'inAuction' => '1',
        ]);

    }
}

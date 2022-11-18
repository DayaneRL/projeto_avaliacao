<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            [
                'description' => 'Os preços que aparecem no cardápio de um restaurante já incluem um acréscimo de 10% referente ao total\r\nde impostos. Na conta, o valor a ser pago contém o acréscimo de 10% relativo aos serviços (gorjeta). Se o\r\nvalor total da conta for 𝑝 reais, o cliente ',
                'image' => 'https://ogimg.infolobo.com.br/in/25393836-124-152/FT1086A/760/teorema-de-pitagoras-png-1.png',
                'level_id'=> 1,
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'description' => 'A representação decimal de certo número inteiro positivo tem dois algarismos. Se o triplo da soma desses\r\nalgarismos é igual ao próprio número, então o produto dos algarismos é igual a \r\n',
                'image' => '0',
                'level_id'=> 2,
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'description' => 'O sistema de segurança de um aeroporto consiste de duas inspeções. Na primeira delas, a probabilidade de\r\num passageiro ser inspecionado é de 3/5. Na segunda, a probabilidade se reduz para 1/4. A probabilidade\r\nde um passageiro ser inspecionado pelo menos ',
                'image' => 'https://ogimg.infoglobo.com.br/in/25393836-124-152/FT1086A/760/teorema-de-pitagoras-png-1.png',
                'level_id'=> 3,
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'description' => 'Sejam 𝑎 e 𝑏 números reais positivos. Considere a função quadrática 𝑓(𝑥) = 𝑥(𝑎𝑥 + 𝑏), definida para todo\r\nnúmero real 𝑥. No plano cartesiano, qual figura corresponde ao gráfico de 𝑦 = 𝑓(𝑥)? ',
                'image' => '0',
                'level_id'=> 1,
                'created_at'=> now(),
                'updated_at'=> now()
            ],

            [
                'description' => 'Sejam 𝑘 e 𝜃 números reais tais que sen 𝜃 e cos 𝜃 são soluções da equação quadrática 2𝑥\r\n2 + 𝑥 +𝑘 = 0.\r\nEntão, 𝑘 é um número',
                'image' => 'https://ogimg.infoglobo.com.br/in/25393836-124-152/FT1086A/760/teorema-de-pitagoras-png-1.png',
                'level_id'=> 2,
                'created_at'=> now(),
                'updated_at'=> now()
            ],
        ]);
    }
}

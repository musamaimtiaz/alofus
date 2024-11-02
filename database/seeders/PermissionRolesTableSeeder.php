<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionRolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('permission_roles')->delete();

        \DB::table('permission_roles')->insert([
            0 => [
                'permission_id' => 278,
                'role_id' => 2,
            ],
            1 => [
                'permission_id' => 279,
                'role_id' => 2,
            ],
            2 => [
                'permission_id' => 280,
                'role_id' => 2,
            ],
            3 => [
                'permission_id' => 281,
                'role_id' => 2,
            ],
            4 => [
                'permission_id' => 72,
                'role_id' => 2,
            ],
            5 => [
                'permission_id' => 73,
                'role_id' => 2,
            ],
            6 => [
                'permission_id' => 74,
                'role_id' => 2,
            ],
            7 => [
                'permission_id' => 76,
                'role_id' => 2,
            ],
            8 => [
                'permission_id' => 295,
                'role_id' => 2,
            ],
            9 => [
                'permission_id' => 114,
                'role_id' => 2,
            ],
            10 => [
                'permission_id' => 113,
                'role_id' => 2,
            ],
            11 => [
                'permission_id' => 112,
                'role_id' => 2,
            ],
            12 => [
                'permission_id' => 111,
                'role_id' => 2,
            ],
            13 => [
                'permission_id' => 110,
                'role_id' => 2,
            ],
            14 => [
                'permission_id' => 109,
                'role_id' => 2,
            ],
            15 => [
                'permission_id' => 108,
                'role_id' => 2,
            ],
            16 => [
                'permission_id' => 107,
                'role_id' => 2,
            ],
            17 => [
                'permission_id' => 106,
                'role_id' => 2,
            ],
            18 => [
                'permission_id' => 294,
                'role_id' => 2,
            ],
            19 => [
                'permission_id' => 293,
                'role_id' => 2,
            ],
            20 => [
                'permission_id' => 292,
                'role_id' => 2,
            ],
            21 => [
                'permission_id' => 336,
                'role_id' => 3,
            ],
            22 => [
                'permission_id' => 394,
                'role_id' => 3,
            ],
            23 => [
                'permission_id' => 395,
                'role_id' => 3,
            ],
            24 => [
                'permission_id' => 396,
                'role_id' => 3,
            ],
            25 => [
                'permission_id' => 403,
                'role_id' => 3,
            ],
            26 => [
                'permission_id' => 397,
                'role_id' => 3,
            ],
            27 => [
                'permission_id' => 398,
                'role_id' => 3,
            ],
            28 => [
                'permission_id' => 399,
                'role_id' => 3,
            ],
            29 => [
                'permission_id' => 400,
                'role_id' => 3,
            ],
            30 => [
                'permission_id' => 401,
                'role_id' => 3,
            ],
            31 => [
                'permission_id' => 402,
                'role_id' => 3,
            ],
            32 => [
                'permission_id' => 388,
                'role_id' => 3,
            ],
            33 => [
                'permission_id' => 389,
                'role_id' => 3,
            ],
            34 => [
                'permission_id' => 390,
                'role_id' => 3,
            ],
            35 => [
                'permission_id' => 391,
                'role_id' => 3,
            ],
            36 => [
                'permission_id' => 392,
                'role_id' => 3,
            ],
            37 => [
                'permission_id' => 393,
                'role_id' => 3,
            ],
            38 => [
                'permission_id' => 335,
                'role_id' => 3,
            ],
            39 => [
                'permission_id' => 334,
                'role_id' => 3,
            ],
            40 => [
                'permission_id' => 323,
                'role_id' => 3,
            ],
            41 => [
                'permission_id' => 254,
                'role_id' => 2,
            ],
            42 => [
                'permission_id' => 336,
                'role_id' => 2,
            ],
            43 => [
                'permission_id' => 419,
                'role_id' => 3,
            ],
            44 => [
                'permission_id' => 428,
                'role_id' => 2,
            ],
            45 => [
                'permission_id' => 431,
                'role_id' => 2,
            ],
            46 => [
                'permission_id' => 408,
                'role_id' => 3,
            ],
            47 => [
                'permission_id' => 420,
                'role_id' => 3,
            ],
            48 => [
                'permission_id' => 432,
                'role_id' => 3,
            ],
            49 => [
                'permission_id' => 433,
                'role_id' => 3,
            ],
            50 => [
                'permission_id' => 434,
                'role_id' => 3,
            ],
            51 => [
                'permission_id' => 435,
                'role_id' => 2,
            ],
            52 => [
                'permission_id' => 421,
                'role_id' => 2,
            ],
            53 => [
                'permission_id' => 466,
                'role_id' => 3,
            ],
            54 => [
                'permission_id' => 464,
                'role_id' => 3,
            ],
            55 => [
                'permission_id' => 460,
                'role_id' => 3,
            ],
            56 => [
                'permission_id' => 465,
                'role_id' => 3,
            ],
            57 => [
                'permission_id' => 461,
                'role_id' => 3,
            ],
            58 => [
                'permission_id' => 462,
                'role_id' => 3,
            ],
            59 => [
                'permission_id' => 463,
                'role_id' => 3,
            ],
            60 => [
                'permission_id' => 453,
                'role_id' => 2,
            ],
            61 => [
                'permission_id' => 459,
                'role_id' => 2,
            ],
            62 => [
                'permission_id' => 454,
                'role_id' => 2,
            ],
            63 => [
                'permission_id' => 455,
                'role_id' => 2,
            ],
            64 => [
                'permission_id' => 458,
                'role_id' => 2,
            ],
            65 => [
                'permission_id' => 456,
                'role_id' => 2,
            ],
            66 => [
                'permission_id' => 314,
                'role_id' => 2,
            ],
            67 => [
                'permission_id' => 320,
                'role_id' => 2,
            ],
            68 => [
                'permission_id' => 319,
                'role_id' => 2,
            ],
            69 => [
                'permission_id' => 318,
                'role_id' => 2,
            ],
            70 => [
                'permission_id' => 317,
                'role_id' => 2,
            ],
            71 => [
                'permission_id' => 316,
                'role_id' => 2,
            ],
            72 => [
                'permission_id' => 315,
                'role_id' => 2,
            ],
            73 => [
                'permission_id' => 403,
                'role_id' => 2,
            ],
            74 => [
                'permission_id' => 457,
                'role_id' => 2,
            ],
            75 => [
                'permission_id' => 496,
                'role_id' => 3,
            ],
            76 => [
                'permission_id' => 497,
                'role_id' => 3,
            ],
            77 => [
                'permission_id' => 5,
                'role_id' => 3,
            ],
            78 => [
                'permission_id' => 499,
                'role_id' => 3,
            ],
            79 => [
                'permission_id' => 501,
                'role_id' => 3,
            ],
            80 => [
                'permission_id' => 502,
                'role_id' => 3,
            ],
            81 => [
                'permission_id' => 503,
                'role_id' => 3,
            ],
            82 => [
                'permission_id' => 510,
                'role_id' => 3,
            ],
            83 => [
                'permission_id' => 509,
                'role_id' => 3,
            ],
            84 => [
                'permission_id' => 508,
                'role_id' => 3,
            ],
            85 => [
                'permission_id' => 511,
                'role_id' => 3,
            ],
            86 => [
                'permission_id' => 512,
                'role_id' => 3,
            ],
            87 => [
                'permission_id' => 514,
                'role_id' => 3,
            ],
            88 => [
                'permission_id' => 272,
                'role_id' => 3,
            ],
            89 => [
                'permission_id' => 515,
                'role_id' => 3,
            ],
            90 => [
                'permission_id' => 271,
                'role_id' => 3,
            ],
            91 => [
                'permission_id' => 500,
                'role_id' => 3,
            ],
            92 => [
                'permission_id' => 505,
                'role_id' => 3,
            ],
            93 => [
                'permission_id' => 504,
                'role_id' => 3,
            ],
            94 => [
                'permission_id' => 311,
                'role_id' => 3,
            ],
            95 => [
                'permission_id' => 310,
                'role_id' => 3,
            ],
            96 => [
                'permission_id' => 557,
                'role_id' => 2,
            ],
            97 => [
                'permission_id' => 556,
                'role_id' => 2,
            ],
            98 => [
                'permission_id' => 555,
                'role_id' => 2,
            ],
            99 => [
                'permission_id' => 554,
                'role_id' => 2,
            ],
            100 => [
                'permission_id' => 558,
                'role_id' => 2,
            ],
            101 => [
                'permission_id' => 562,
                'role_id' => 2,
            ],
            102 => [
                'permission_id' => 565,
                'role_id' => 3,
            ],
            103 => [
                'permission_id' => 583,
                'role_id' => 2,
            ],
            104 => [
                'permission_id' => 584,
                'role_id' => 2,
            ],
            105 => [
                'permission_id' => 585,
                'role_id' => 2,
            ],
            106 => [
                'permission_id' => 640,
                'role_id' => 2,
            ],
            107 => [
                'permission_id' => 636,
                'role_id' => 2,
            ],
            108 => [
                'permission_id' => 637,
                'role_id' => 2,
            ],
            109 => [
                'permission_id' => 638,
                'role_id' => 2,
            ],
            110 => [
                'permission_id' => 639,
                'role_id' => 2,
            ],
            111 => [
                'permission_id' => 641,
                'role_id' => 2,
            ],
            112 => [
                'permission_id' => 642,
                'role_id' => 2,
            ],
            113 => [
                'permission_id' => 643,
                'role_id' => 2,
            ],
            114 => [
                'permission_id' => 644,
                'role_id' => 2,
            ],
            115 => [
                'permission_id' => 646,
                'role_id' => 2,
            ],
            116 => [
                'permission_id' => 647,
                'role_id' => 2,
            ],
            117 => [
                'permission_id' => 643,
                'role_id' => 3,
            ],
            118 => [
                'permission_id' => 685,
                'role_id' => 3,
            ],
            119 => [
                'permission_id' => 703,
                'role_id' => 3,
            ],
            120 => [
                'permission_id' => 704,
                'role_id' => 3,
            ],
            121 => [
                'permission_id' => 457,
                'role_id' => 3,
            ],
            122 => [
                'permission_id' => 318,
                'role_id' => 3,
            ],
            123 => [
                'permission_id' => 471,
                'role_id' => 3,
            ],
            124 => [
                'permission_id' => 410,
                'role_id' => 3,
            ],
            125 => [
                'permission_id' => 404,
                'role_id' => 3,
            ],
            126 => [
                'permission_id' => 405,
                'role_id' => 3,
            ],
            127 => [
                'permission_id' => 407,
                'role_id' => 3,
            ],
            128 => [
                'permission_id' => 406,
                'role_id' => 3,
            ],
            129 => [
                'permission_id' => 411,
                'role_id' => 3,
            ],
            130 => [
                'permission_id' => 412,
                'role_id' => 3,
            ],
            131 => [
                'permission_id' => 476,
                'role_id' => 3,
            ],
            132 => [
                'permission_id' => 475,
                'role_id' => 3,
            ],
            133 => [
                'permission_id' => 474,
                'role_id' => 3,
            ],
            134 => [
                'permission_id' => 573,
                'role_id' => 3,
            ],
            135 => [
                'permission_id' => 333,
                'role_id' => 3,
            ],
            136 => [
                'permission_id' => 332,
                'role_id' => 3,
            ],
            137 => [
                'permission_id' => 681,
                'role_id' => 3,
            ],
            138 => [
                'permission_id' => 682,
                'role_id' => 3,
            ],
            139 => [
                'permission_id' => 324,
                'role_id' => 3,
            ],
            140 => [
                'permission_id' => 326,
                'role_id' => 3,
            ],
            141 => [
                'permission_id' => 331,
                'role_id' => 3,
            ],
            142 => [
                'permission_id' => 330,
                'role_id' => 3,
            ],
            143 => [
                'permission_id' => 329,
                'role_id' => 3,
            ],
            144 => [
                'permission_id' => 328,
                'role_id' => 3,
            ],
            145 => [
                'permission_id' => 325,
                'role_id' => 3,
            ],
            146 => [
                'permission_id' => 683,
                'role_id' => 3,
            ],
            147 => [
                'permission_id' => 566,
                'role_id' => 3,
            ],
            148 => [
                'permission_id' => 801,
                'role_id' => 3,
            ],
            149 => [
                'permission_id' => 800,
                'role_id' => 3,
            ],
            150 => [
                'permission_id' => 802,
                'role_id' => 3,
            ],
            151 => [
                'permission_id' => 571,
                'role_id' => 3,
            ],
            152 => [
                'permission_id' => 777,
                'role_id' => 3,
            ],
            153 => [
                'permission_id' => 563,
                'role_id' => 3,
            ],
            154 => [
                'permission_id' => 469,
                'role_id' => 3,
            ],
            155 => [
                'permission_id' => 468,
                'role_id' => 3,
            ],
            156 => [
                'permission_id' => 467,
                'role_id' => 3,
            ],
            157 => [
                'permission_id' => 644,
                'role_id' => 3,
            ],
            158 => [
                'permission_id' => 687,
                'role_id' => 3,
            ],
            159 => [
                'permission_id' => 473,
                'role_id' => 3,
            ],
            160 => [
                'permission_id' => 531,
                'role_id' => 3,
            ],
            161 => [
                'permission_id' => 640,
                'role_id' => 3,
            ],
            162 => [
                'permission_id' => 639,
                'role_id' => 3,
            ],
            163 => [
                'permission_id' => 636,
                'role_id' => 3,
            ],
            164 => [
                'permission_id' => 635,
                'role_id' => 3,
            ],
            165 => [
                'permission_id' => 679,
                'role_id' => 3,
            ],
            166 => [
                'permission_id' => 641,
                'role_id' => 3,
            ],
            167 => [
                'permission_id' => 637,
                'role_id' => 3,
            ],
            168 => [
                'permission_id' => 642,
                'role_id' => 3,
            ],
            169 => [
                'permission_id' => 638,
                'role_id' => 3,
            ],
            170 => [
                'permission_id' => 529,
                'role_id' => 3,
            ],
            171 => [
                'permission_id' => 632,
                'role_id' => 3,
            ],
            172 => [
                'permission_id' => 634,
                'role_id' => 3,
            ],
            173 => [
                'permission_id' => 633,
                'role_id' => 3,
            ],
            174 => [
                'permission_id' => 798,
                'role_id' => 3,
            ],
            175 => [
                'permission_id' => 498,
                'role_id' => 3,
            ],
            176 => [
                'permission_id' => 796,
                'role_id' => 2,
            ],
            177 => [
                'permission_id' => 795,
                'role_id' => 2,
            ],
            178 => [
                'permission_id' => 794,
                'role_id' => 2,
            ],
            179 => [
                'permission_id' => 793,
                'role_id' => 2,
            ],
            180 => [
                'permission_id' => 791,
                'role_id' => 2,
            ],
            181 => [
                'permission_id' => 792,
                'role_id' => 2,
            ],
            182 => [
                'permission_id' => 790,
                'role_id' => 2,
            ],
            183 => [
                'permission_id' => 789,
                'role_id' => 2,
            ],
            184 => [
                'permission_id' => 772,
                'role_id' => 2,
            ],
            185 => [
                'permission_id' => 771,
                'role_id' => 2,
            ],
            186 => [
                'permission_id' => 776,
                'role_id' => 2,
            ],
            187 => [
                'permission_id' => 774,
                'role_id' => 2,
            ],
            188 => [
                'permission_id' => 690,
                'role_id' => 2,
            ],
            189 => [
                'permission_id' => 691,
                'role_id' => 2,
            ],
            190 => [
                'permission_id' => 692,
                'role_id' => 2,
            ],
            191 => [
                'permission_id' => 693,
                'role_id' => 2,
            ],
            192 => [
                'permission_id' => 694,
                'role_id' => 2,
            ],
            193 => [
                'permission_id' => 695,
                'role_id' => 2,
            ],
            194 => [
                'permission_id' => 696,
                'role_id' => 2,
            ],
            195 => [
                'permission_id' => 698,
                'role_id' => 2,
            ],
            196 => [
                'permission_id' => 751,
                'role_id' => 2,
            ],
            197 => [
                'permission_id' => 821,
                'role_id' => 2,
            ],
            198 => [
                'permission_id' => 822,
                'role_id' => 2,
            ],
            199 => [
                'permission_id' => 823,
                'role_id' => 2,
            ],
            200 => [
                'permission_id' => 803,
                'role_id' => 2,
            ],
            201 => [
                'permission_id' => 804,
                'role_id' => 2,
            ],
            202 => [
                'permission_id' => 805,
                'role_id' => 2,
            ],
            203 => [
                'permission_id' => 806,
                'role_id' => 2,
            ],
            204 => [
                'permission_id' => 807,
                'role_id' => 2,
            ],
            205 => [
                'permission_id' => 768,
                'role_id' => 2,
            ],
            206 => [
                'permission_id' => 766,
                'role_id' => 2,
            ],
            207 => [
                'permission_id' => 767,
                'role_id' => 2,
            ],
            208 => [
                'permission_id' => 769,
                'role_id' => 2,
            ],
            209 => [
                'permission_id' => 770,
                'role_id' => 2,
            ],
            210 => [
                'permission_id' => 835,
                'role_id' => 3,
            ],
            211 => [
                'permission_id' => 703,
                'role_id' => 2,
            ],
            212 => [
                'permission_id' => 397,
                'role_id' => 2,
            ],
            213 => [
                'permission_id' => 398,
                'role_id' => 2,
            ],
            214 => [
                'permission_id' => 399,
                'role_id' => 2,
            ],
            215 => [
                'permission_id' => 400,
                'role_id' => 2,
            ],
            216 => [
                'permission_id' => 401,
                'role_id' => 2,
            ],
            217 => [
                'permission_id' => 402,
                'role_id' => 2,
            ],
            218 => [
                'permission_id' => 685,
                'role_id' => 2,
            ],
            219 => [
                'permission_id' => 404,
                'role_id' => 2,
            ],
            220 => [
                'permission_id' => 405,
                'role_id' => 2,
            ],
            221 => [
                'permission_id' => 406,
                'role_id' => 2,
            ],
            222 => [
                'permission_id' => 407,
                'role_id' => 2,
            ],
            223 => [
                'permission_id' => 410,
                'role_id' => 2,
            ],
            224 => [
                'permission_id' => 411,
                'role_id' => 2,
            ],
            225 => [
                'permission_id' => 412,
                'role_id' => 2,
            ],
            226 => [
                'permission_id' => 471,
                'role_id' => 2,
            ],
            227 => [
                'permission_id' => 475,
                'role_id' => 2,
            ],
            228 => [
                'permission_id' => 474,
                'role_id' => 2,
            ],
            229 => [
                'permission_id' => 476,
                'role_id' => 2,
            ],
            230 => [
                'permission_id' => 419,
                'role_id' => 2,
            ],
            231 => [
                'permission_id' => 565,
                'role_id' => 2,
            ],
            232 => [
                'permission_id' => 573,
                'role_id' => 2,
            ],
            233 => [
                'permission_id' => 328,
                'role_id' => 2,
            ],
            234 => [
                'permission_id' => 683,
                'role_id' => 2,
            ],
            235 => [
                'permission_id' => 325,
                'role_id' => 2,
            ],
            236 => [
                'permission_id' => 326,
                'role_id' => 2,
            ],
            237 => [
                'permission_id' => 324,
                'role_id' => 2,
            ],
            238 => [
                'permission_id' => 682,
                'role_id' => 2,
            ],
            239 => [
                'permission_id' => 681,
                'role_id' => 2,
            ],
            240 => [
                'permission_id' => 329,
                'role_id' => 2,
            ],
            241 => [
                'permission_id' => 330,
                'role_id' => 2,
            ],
            242 => [
                'permission_id' => 333,
                'role_id' => 2,
            ],
            243 => [
                'permission_id' => 331,
                'role_id' => 2,
            ],
            244 => [
                'permission_id' => 332,
                'role_id' => 2,
            ],
            245 => [
                'permission_id' => 834,
                'role_id' => 2,
            ],
            246 => [
                'permission_id' => 833,
                'role_id' => 2,
            ],
            247 => [
                'permission_id' => 462,
                'role_id' => 2,
            ],
            248 => [
                'permission_id' => 463,
                'role_id' => 2,
            ],
            249 => [
                'permission_id' => 879,
                'role_id' => 2,
            ],
            250 => [
                'permission_id' => 461,
                'role_id' => 2,
            ],
            251 => [
                'permission_id' => 566,
                'role_id' => 2,
            ],
            252 => [
                'permission_id' => 420,
                'role_id' => 2,
            ],
            253 => [
                'permission_id' => 408,
                'role_id' => 2,
            ],
            254 => [
                'permission_id' => 879,
                'role_id' => 3,
            ],
            255 => [
                'permission_id' => 834,
                'role_id' => 3,
            ],
            256 => [
                'permission_id' => 833,
                'role_id' => 3,
            ],
            257 => [
                'permission_id' => 883,
                'role_id' => 3,
            ],
            258 => [
                'permission_id' => 837,
                'role_id' => 3,
            ],
            259 => [
                'permission_id' => 884,
                'role_id' => 3,
            ],
            260 => [
                'permission_id' => 878,
                'role_id' => 3,
            ],
            261 => [
                'permission_id' => 877,
                'role_id' => 3,
            ],
            262 => [
                'permission_id' => 883,
                'role_id' => 2,
            ],
            263 => [
                'permission_id' => 802,
                'role_id' => 2,
            ],
            264 => [
                'permission_id' => 837,
                'role_id' => 2,
            ],
            265 => [
                'permission_id' => 801,
                'role_id' => 2,
            ],
            266 => [
                'permission_id' => 800,
                'role_id' => 2,
            ],
            267 => [
                'permission_id' => 884,
                'role_id' => 2,
            ],
            268 => [
                'permission_id' => 704,
                'role_id' => 2,
            ],
            269 => [
                'permission_id' => 777,
                'role_id' => 2,
            ],
            270 => [
                'permission_id' => 563,
                'role_id' => 2,
            ],
            271 => [
                'permission_id' => 571,
                'role_id' => 2,
            ],
            272 => [
                'permission_id' => 466,
                'role_id' => 2,
            ],
            273 => [
                'permission_id' => 465,
                'role_id' => 2,
            ],
            274 => [
                'permission_id' => 464,
                'role_id' => 2,
            ],
            275 => [
                'permission_id' => 460,
                'role_id' => 2,
            ],
            276 => [
                'permission_id' => 469,
                'role_id' => 2,
            ],
            277 => [
                'permission_id' => 687,
                'role_id' => 2,
            ],
            278 => [
                'permission_id' => 467,
                'role_id' => 2,
            ],
            279 => [
                'permission_id' => 468,
                'role_id' => 2,
            ],
            280 => [
                'permission_id' => 334,
                'role_id' => 2,
            ],
            281 => [
                'permission_id' => 323,
                'role_id' => 2,
            ],
            282 => [
                'permission_id' => 878,
                'role_id' => 2,
            ],
            283 => [
                'permission_id' => 335,
                'role_id' => 2,
            ],
            284 => [
                'permission_id' => 473,
                'role_id' => 2,
            ],
            285 => [
                'permission_id' => 877,
                'role_id' => 2,
            ],
            286 => [
                'permission_id' => 393,
                'role_id' => 2,
            ],
            287 => [
                'permission_id' => 835,
                'role_id' => 2,
            ],
            288 => [
                'permission_id' => 388,
                'role_id' => 2,
            ],
            289 => [
                'permission_id' => 389,
                'role_id' => 2,
            ],
            290 => [
                'permission_id' => 390,
                'role_id' => 2,
            ],
            291 => [
                'permission_id' => 391,
                'role_id' => 2,
            ],
            292 => [
                'permission_id' => 392,
                'role_id' => 2,
            ],
            293 => [
                'permission_id' => 395,
                'role_id' => 2,
            ],
            294 => [
                'permission_id' => 394,
                'role_id' => 2,
            ],
            295 => [
                'permission_id' => 396,
                'role_id' => 2,
            ],
            296 => [
                'permission_id' => 886,
                'role_id' => 2,
            ],
            297 => [
                'permission_id' => 886,
                'role_id' => 3,
            ],
            298 => [
                'permission_id' => 773,
                'role_id' => 2,
            ],
            299 => [
                'permission_id' => 775,
                'role_id' => 2,
            ],
            300 => [
                'permission_id' => 758,
                'role_id' => 2,
            ],
            301 => [
                'permission_id' => 760,
                'role_id' => 2,
            ],
            302 => [
                'permission_id' => 885,
                'role_id' => 2,
            ],
            303 => [
                'permission_id' => 1005,
                'role_id' => 3,
            ],
            304 => [
                'permission_id' => 1006,
                'role_id' => 3,
            ],
            305 => [
                'permission_id' => 1007,
                'role_id' => 3,
            ],
            306 => [
                'permission_id' => 1004,
                'role_id' => 3,
            ],
            307 => [
                'permission_id' => 1087,
                'role_id' => 2,
            ],
            308 => [
                'permission_id' => 1088,
                'role_id' => 2,
            ],
            309 => [
                'permission_id' => 1089,
                'role_id' => 2,
            ],
            310 => [
                'permission_id' => 1090,
                'role_id' => 2,
            ],
            311 => [
                'permission_id' => 1091,
                'role_id' => 2,
            ],
            312 => [
                'permission_id' => 1092,
                'role_id' => 2,
            ],
            313 => [
                'permission_id' => 1093,
                'role_id' => 2,
            ],
            314 => [
                'permission_id' => 1094,
                'role_id' => 2,
            ],
            315 => [
                'permission_id' => 919,
                'role_id' => 2,
            ],
            316 => [
                'permission_id' => 1126,
                'role_id' => 2,
            ],
            317 => [
                'permission_id' => 1122,
                'role_id' => 2,
            ],
            318 => [
                'permission_id' => 1120,
                'role_id' => 2,
            ],
            319 => [
                'permission_id' => 1114,
                'role_id' => 2,
            ],
            320 => [
                'permission_id' => 1114,
                'role_id' => 3,
            ],
            321 => [
                'permission_id' => 911,
                'role_id' => 2,
            ],
            322 => [
                'permission_id' => 911,
                'role_id' => 3,
            ],
            323 => [
                'permission_id' => 912,
                'role_id' => 2,
            ],
            324 => [
                'permission_id' => 912,
                'role_id' => 3,
            ],
            325 => [
                'permission_id' => 913,
                'role_id' => 2,
            ],
            326 => [
                'permission_id' => 913,
                'role_id' => 3,
            ],
            327 => [
                'permission_id' => 1010,
                'role_id' => 2,
            ],
            328 => [
                'permission_id' => 1010,
                'role_id' => 3,
            ],
            329 => [
                'permission_id' => 1011,
                'role_id' => 2,
            ],
            330 => [
                'permission_id' => 1011,
                'role_id' => 3,
            ],
            331 => [
                'permission_id' => 1017,
                'role_id' => 3,
            ],
            332 => [
                'permission_id' => 1017,
                'role_id' => 2,
            ],
            333 => [
                'permission_id' => 1115,
                'role_id' => 2,
            ],
            334 => [
                'permission_id' => 1115,
                'role_id' => 3,
            ],
            335 => [
                'permission_id' => 1012,
                'role_id' => 2,
            ],
            336 => [
                'permission_id' => 1012,
                'role_id' => 3,
            ],
            337 => [
                'permission_id' => 1013,
                'role_id' => 3,
            ],
            338 => [
                'permission_id' => 1014,
                'role_id' => 3,
            ],
            339 => [
                'permission_id' => 1015,
                'role_id' => 3,
            ],
            340 => [
                'permission_id' => 1016,
                'role_id' => 3,
            ],
            341 => [
                'permission_id' => 1016,
                'role_id' => 2,
            ],
            342 => [
                'permission_id' => 1015,
                'role_id' => 2,
            ],
            343 => [
                'permission_id' => 1014,
                'role_id' => 2,
            ],
            344 => [
                'permission_id' => 1013,
                'role_id' => 2,
            ],
            345 => [
                'permission_id' => 916,
                'role_id' => 2,
            ],
            346 => [
                'permission_id' => 916,
                'role_id' => 3,
            ],
            347 => [
                'permission_id' => 915,
                'role_id' => 2,
            ],
            348 => [
                'permission_id' => 915,
                'role_id' => 3,
            ],
            349 => [
                'permission_id' => 508,
                'role_id' => 2,
            ],
            350 => [
                'permission_id' => 509,
                'role_id' => 2,
            ],
            351 => [
                'permission_id' => 510,
                'role_id' => 2,
            ],
            352 => [
                'permission_id' => 511,
                'role_id' => 2,
            ],
            353 => [
                'permission_id' => 531,
                'role_id' => 2,
            ],
            354 => [
                'permission_id' => 635,
                'role_id' => 2,
            ],
            355 => [
                'permission_id' => 679,
                'role_id' => 2,
            ],
            356 => [
                'permission_id' => 529,
                'role_id' => 2,
            ],
            357 => [
                'permission_id' => 825,
                'role_id' => 2,
            ],
            358 => [
                'permission_id' => 825,
                'role_id' => 3,
            ],
            359 => [
                'permission_id' => 512,
                'role_id' => 2,
            ],
            360 => [
                'permission_id' => 514,
                'role_id' => 2,
            ],
            361 => [
                'permission_id' => 632,
                'role_id' => 2,
            ],
            362 => [
                'permission_id' => 633,
                'role_id' => 2,
            ],
            363 => [
                'permission_id' => 634,
                'role_id' => 2,
            ],
            364 => [
                'permission_id' => 826,
                'role_id' => 2,
            ],
            365 => [
                'permission_id' => 827,
                'role_id' => 2,
            ],
            366 => [
                'permission_id' => 1102,
                'role_id' => 2,
            ],
            367 => [
                'permission_id' => 826,
                'role_id' => 3,
            ],
            368 => [
                'permission_id' => 827,
                'role_id' => 3,
            ],
            369 => [
                'permission_id' => 1102,
                'role_id' => 3,
            ],
            370 => [
                'permission_id' => 798,
                'role_id' => 2,
            ],
            371 => [
                'permission_id' => 1004,
                'role_id' => 2,
            ],
            372 => [
                'permission_id' => 1005,
                'role_id' => 2,
            ],
            373 => [
                'permission_id' => 1006,
                'role_id' => 2,
            ],
            374 => [
                'permission_id' => 1007,
                'role_id' => 2,
            ],
            375 => [
                'permission_id' => 503,
                'role_id' => 2,
            ],
            376 => [
                'permission_id' => 998,
                'role_id' => 2,
            ],
            377 => [
                'permission_id' => 1001,
                'role_id' => 2,
            ],
            378 => [
                'permission_id' => 1002,
                'role_id' => 2,
            ],
            379 => [
                'permission_id' => 998,
                'role_id' => 3,
            ],
            380 => [
                'permission_id' => 1001,
                'role_id' => 3,
            ],
            381 => [
                'permission_id' => 1002,
                'role_id' => 3,
            ],
            382 => [
                'permission_id' => 496,
                'role_id' => 2,
            ],
            383 => [
                'permission_id' => 497,
                'role_id' => 2,
            ],
            384 => [
                'permission_id' => 498,
                'role_id' => 2,
            ],
            385 => [
                'permission_id' => 499,
                'role_id' => 2,
            ],
            386 => [
                'permission_id' => 874,
                'role_id' => 2,
            ],
            387 => [
                'permission_id' => 874,
                'role_id' => 3,
            ],
            388 => [
                'permission_id' => 501,
                'role_id' => 2,
            ],
            389 => [
                'permission_id' => 502,
                'role_id' => 2,
            ],
            390 => [
                'permission_id' => 1116,
                'role_id' => 2,
            ],
            391 => [
                'permission_id' => 1110,
                'role_id' => 2,
            ],
            392 => [
                'permission_id' => 1111,
                'role_id' => 2,
            ],
            393 => [
                'permission_id' => 1112,
                'role_id' => 2,
            ],
            394 => [
                'permission_id' => 1113,
                'role_id' => 2,
            ],
            395 => [
                'permission_id' => 1128,
                'role_id' => 2,
            ],
            396 => [
                'permission_id' => 1129,
                'role_id' => 2,
            ],
            397 => [
                'permission_id' => 901,
                'role_id' => 2,
            ],
            398 => [
                'permission_id' => 902,
                'role_id' => 2,
            ],
            399 => [
                'permission_id' => 903,
                'role_id' => 2,
            ],
            400 => [
                'permission_id' => 904,
                'role_id' => 2,
            ],
            401 => [
                'permission_id' => 905,
                'role_id' => 2,
            ],
            402 => [
                'permission_id' => 906,
                'role_id' => 2,
            ],
            403 => [
                'permission_id' => 907,
                'role_id' => 2,
            ],
            404 => [
                'permission_id' => 1136,
                'role_id' => 2,
            ],
            405 => [
                'permission_id' => 1142,
                'role_id' => 3,
            ],
            406 => [
                'permission_id' => 1143,
                'role_id' => 3,
            ],
            407 => [
                'permission_id' => 1144,
                'role_id' => 3,
            ],
            408 => [
                'permission_id' => 1145,
                'role_id' => 3,
            ],
            409 => [
                'permission_id' => 1152,
                'role_id' => 3,
            ],
            410 => [
                'permission_id' => 1153,
                'role_id' => 3,
            ],
            411 => [
                'permission_id' => 1154,
                'role_id' => 3,
            ],
            412 => [
                'permission_id' => 1155,
                'role_id' => 3,
            ],
            413 => [
                'permission_id' => 1156,
                'role_id' => 3,
            ],
            414 => [
                'permission_id' => 1146,
                'role_id' => 3,
            ],
            415 => [
                'permission_id' => 1147,
                'role_id' => 3,
            ],
            416 => [
                'permission_id' => 1148,
                'role_id' => 3,
            ],
            417 => [
                'permission_id' => 1149,
                'role_id' => 3,
            ],
            418 => [
                'permission_id' => 1150,
                'role_id' => 3,
            ],
            419 => [
                'permission_id' => 1151,
                'role_id' => 3,
            ],
            420 => [
                'permission_id' => 1066,
                'role_id' => 2,
            ],
            421 => [
                'permission_id' => 1143,
                'role_id' => 2,
            ],
            422 => [
                'permission_id' => 1142,
                'role_id' => 2,
            ],
            423 => [
                'permission_id' => 1145,
                'role_id' => 2,
            ],
            424 => [
                'permission_id' => 1164,
                'role_id' => 2,
            ],
            425 => [
                'permission_id' => 1164,
                'role_id' => 3,
            ],
            426 => [
                'permission_id' => 1138,
                'role_id' => 2,
            ],
            427 => [
                'permission_id' => 1138,
                'role_id' => 3,
            ],
            428 => [
                'permission_id' => 1139,
                'role_id' => 2,
            ],
            429 => [
                'permission_id' => 1139,
                'role_id' => 3,
            ],
            430 => [
                'permission_id' => 1137,
                'role_id' => 2,
            ],
            431 => [
                'permission_id' => 1137,
                'role_id' => 3,
            ],
            432 => [
                'permission_id' => 1165,
                'role_id' => 2,
            ],
            433 => [
                'permission_id' => 1165,
                'role_id' => 3,
            ],
            434 => [
                'permission_id' => 1163,
                'role_id' => 2,
            ],
            435 => [
                'permission_id' => 1163,
                'role_id' => 3,
            ],
            436 => [
                'permission_id' => 1152,
                'role_id' => 2,
            ],
            437 => [
                'permission_id' => 1153,
                'role_id' => 2,
            ],
            438 => [
                'permission_id' => 1154,
                'role_id' => 2,
            ],
            439 => [
                'permission_id' => 1155,
                'role_id' => 2,
            ],
            440 => [
                'permission_id' => 1156,
                'role_id' => 2,
            ],
            441 => [
                'permission_id' => 1141,
                'role_id' => 2,
            ],
            442 => [
                'permission_id' => 1141,
                'role_id' => 3,
            ],
            443 => [
                'permission_id' => 1144,
                'role_id' => 2,
            ],
            444 => [
                'permission_id' => 1167,
                'role_id' => 2,
            ],
            445 => [
                'permission_id' => 1167,
                'role_id' => 3,
            ],
            446 => [
                'permission_id' => 1157,
                'role_id' => 2,
            ],
            447 => [
                'permission_id' => 1157,
                'role_id' => 3,
            ],
            448 => [
                'permission_id' => 1146,
                'role_id' => 2,
            ],
            449 => [
                'permission_id' => 1147,
                'role_id' => 2,
            ],
            450 => [
                'permission_id' => 1148,
                'role_id' => 2,
            ],
            451 => [
                'permission_id' => 1149,
                'role_id' => 2,
            ],
            452 => [
                'permission_id' => 1150,
                'role_id' => 2,
            ],
            453 => [
                'permission_id' => 1151,
                'role_id' => 2,
            ],
            454 => [
                'permission_id' => 1179,
                'role_id' => 2,
            ],
            455 => [
                'permission_id' => 1179,
                'role_id' => 3,
            ],
            456 => [
                'permission_id' => 1181,
                'role_id' => 2,
            ],
            457 => [
                'permission_id' => 1181,
                'role_id' => 3,
            ],
            458 => [
                'permission_id' => 1200,
                'role_id' => 2,
            ],
            459 => [
                'permission_id' => 788,
                'role_id' => 2,
            ],
            460 => [
                'permission_id' => 1206,
                'role_id' => 2,
            ],
            461 => [
                'permission_id' => 1212,
                'role_id' => 2,
            ],
            462 => [
                'permission_id' => 699,
                'role_id' => 2,
            ],
            463 => [
                'permission_id' => 699,
                'role_id' => 3,
            ],
            464 => [
                'permission_id' => 699,
                'role_id' => 4,
            ],
            465 => [
                'permission_id' => 1217,
                'role_id' => 2,
            ],
            466 => [
                'permission_id' => 1217,
                'role_id' => 3,
            ],
            467 => [
                'permission_id' => 1217,
                'role_id' => 4,
            ],
            468 => [
                'permission_id' => 1231,
                'role_id' => 3,
            ],
            469 => [
                'permission_id' => 1232,
                'role_id' => 3,
            ],
            470 => [
                'permission_id' => 1233,
                'role_id' => 2,
            ],
            471 => [
                'permission_id' => 1234,
                'role_id' => 2,
            ],
            472 => [
                'permission_id' => 1191,
                'role_id' => 2,
            ],
            473 => [
                'permission_id' => 1192,
                'role_id' => 2,
            ],
            474 => [
                'permission_id' => 1193,
                'role_id' => 2,
            ],
            475 => [
                'permission_id' => 1231,
                'role_id' => 2,
            ],
            476 => [
                'permission_id' => 1205,
                'role_id' => 2,
            ],
            477 => [
                'permission_id' => 1240,
                'role_id' => 2,
            ],
            478 => [
                'permission_id' => 1232,
                'role_id' => 2,
            ],
            479 => [
                'permission_id' => 1253,
                'role_id' => 2,
            ],
            480 => [
                'permission_id' => 1158,
                'role_id' => 2,
            ],
            481 => [
                'permission_id' => 1186,
                'role_id' => 2,
            ],
            482 => [
                'permission_id' => 1186,
                'role_id' => 3,
            ],
            483 => [
                'permission_id' => 1180,
                'role_id' => 2,
            ],
            484 => [
                'permission_id' => 1180,
                'role_id' => 3,
            ],
            485 => [
                'permission_id' => 1202,
                'role_id' => 2,
            ],
            486 => [
                'permission_id' => 1202,
                'role_id' => 3,
            ],
            487 => [
                'permission_id' => 1203,
                'role_id' => 3,
            ],
            488 => [
                'permission_id' => 1203,
                'role_id' => 2,
            ],
            489 => [
                'permission_id' => 1198,
                'role_id' => 2,
            ],
            490 => [
                'permission_id' => 1198,
                'role_id' => 3,
            ],
            491 => [
                'permission_id' => 1187,
                'role_id' => 2,
            ],
            492 => [
                'permission_id' => 1187,
                'role_id' => 3,
            ],
            493 => [
                'permission_id' => 1185,
                'role_id' => 2,
            ],
            494 => [
                'permission_id' => 1185,
                'role_id' => 3,
            ],
            495 => [
                'permission_id' => 1204,
                'role_id' => 3,
            ],
            496 => [
                'permission_id' => 1204,
                'role_id' => 2,
            ],
            497 => [
                'permission_id' => 1256,
                'role_id' => 2,
            ],
            498 => [
                'permission_id' => 1256,
                'role_id' => 3,
            ],
            499 => [
                'permission_id' => 1258,
                'role_id' => 2,
            ],
        ]);
        \DB::table('permission_roles')->insert([
            0 => [
                'permission_id' => 1260,
                'role_id' => 2,
            ],
            1 => [
                'permission_id' => 1261,
                'role_id' => 3,
            ],
        ]);
    }
}

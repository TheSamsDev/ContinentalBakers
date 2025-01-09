<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storeData = [
            ['TESCO SUPER MARKET', 'SHOP 1 2 PLOT 9C SHAHBAZ MARKET KHAYBANESAHAR PHASE 6', 'MINI MARKET PH-5'],
            ['ZAINAB FAMILY MART', 'SECTOR-15A/1,KDA EMPLOYES SOCIETY,GULZAR-E-HIJRI,GULSHAN-E-IQBAL', 'GULZAR HIJRI THANA'],
            ['MACCA MADINA SUPER STORE', 'OPP BABA ICE CREAM,BURNS ROAD', 'BURNS ROAD'],
            ['Shop & Save General & Grocery Store', 'SHOP NO 5-6-7 MARINE ARCADE BLOCK 3 BILAWAL HOUSE CLIFTON', 'BILAWAL HOUSE BELT'],
            ['Bismillah G Store', 'Sector D Road no 8 manzoor colony block 6J1', 'MANZOOR COLONY'],
            ['KARACHI SUPER STORE', 'PLOT NO C7 BLOCK 3 NEAR SAFORA CHOWRANGI KARACHI', 'SAFOORA GOTH'],
            ['HYPER LINK SMART', 'BISMILLAH TOWER BLOCK-10 GULISTAN-E-JOHAR', 'PEHALWAN GOTH'],
            ['Your Mart', 'Darulsalam Society Korangi Block A Sec 2 Street 5 Near Indus Hospital', 'NASIR COLONY'],
            ['Acme Mart', 'Plot No LS-386-389 Sec 33/D Near Al-Madina Jama Masjid Korangi No 2 ½', 'KORANGI NO - 2 MARKET'],
            ['Tayyab General Store', '1117-18 Block-3 F .B. Area', 'HUSSAINABAD'],
            ['P.Z Super Store & Pharmacy', 'Shop No A-41 Block-13 Gulistan-e-Johar', 'GULISTAN-E-JOHAR BLK - 13 ,RAD'],
            ['AL JALAL GENERAL STORE', 'SHOP NO. 27/28, BHAYANI APPARTMENT NORTH NAZIMABAD BLOCK J', 'NORTH NAZIMABAD BL- K'],
            ['cantt medical store', 'Royal Reidency Plot No CL-15 Civil Quarter Karachi', 'CANTT STATION'],
            ['SHOP N SAVE SUPER MART 2', 'SHOP 3 ROYAL RESIDENCY MAIN CANTT STATION NEAR POST OFFICE', 'CANTT STATION'],
            ['AYYAN SUPER MART', 'A-169 BLOCK Z-5 GULSHAN-E-MAYMAR', 'GULSHAN-E-MAYMAR SOCIETY'],
            ['Mashallah Bakery & GENERAL STORE', 'Faizan Highets Fawara Choke Garden West', 'SOLDIER BAZAR(1 TO 3 )'],
            ['BILAL MART 3', 'MINICOMMERCIAL AREA NAYA NAZIMABAD', 'NORTH NAZIMABAD BL- T'],
            ['AZEEMS SUPER MARKET', 'PLOTNO S/C -8 BLK-7 UZMA CORNER OPPOSITE UZMA SHOPPING MALL CLIFTON ROAD KARACHI SOUTH SADDAR TOWN.', 'CLIFTON (AGHAS BELT)'],
            ['AL JANNAT GENERAL STORE', 'SHOP NO,4 ALFALAH SQUARE BLK H NORTH NAZIMABAD', 'NORTH NAZIMABAD BL- H'],
            ['Dawood Super Mart', 'Street no 9 Clifton Block 6 N/B Arwa Food', 'BOAT BASON'],
            ['STOP N BUY GENERAL STORE', 'SHOP-2,SONIA ARCADE,SOLDIER BAZAR-3', 'SOLDIER BAZAR(1 TO 3 )'],
            ['IRFAN Wholeseller', 'OPPOSITE KHAN SWEETS SIKANDER GOTH', 'SINDH BALOCHISTAN SOCIETY'],
            ['AL-SAFAA SUPER MARKET', 'OPPOSITE BISMILLAH TOWER NEAR HYPER LINK BLOCK 15 GULISTAN-E-JOHAR', 'CULISTAN-E-JOHAR BLOCK - 15'],
            ['SHAN-E-SABARIE', 'BHATTAI COLONY H NO 405', 'BHITHAI COLONY'],
            ['RAINBOW MART', 'PLOT NO,A87 TAQI CENTRE BLK J NORTH NAZIMABAD', 'NORTH NAZIMABAD BL- J'],
            ['AL-SAUDIA SUPER MART', 'GULSHANE MAYMAR SEC Z-5 SHOP NO A-5 NEAR DUBAI MART', 'GULSHAN-E-MAYMAR SOCIETY'],
            ['ocean super mart & pharmacy', 'GROUND DASEMENT FLOOR PIONT NO 22 BADAR COMMERCIAL STREET NO 6 DHA PHS V EXT', 'BADAR COMMERCIAL PH-5'],
            ['Saving Home', 'B-10 Memon Nagar Sector 13-A Scheme 33 Gulzar-E-Hijri', 'GULZAR HIJRI THANA'],
            ['ANCHOR MART', 'DALMIA ROAD(S.R.E MAJEED),GULSHAN-E-IQBAL', 'DALMIA ROAD'],
            ['AL-KARIM SUPER MART AND CHEMIST', 'SHOP NO.9-10-11,BLOCK-E,FAROOQ MARKET, HAIDRY KARACHI.', 'POLICE WELFARE SHOPPING CENTRE'],
            ['AL KARAM STORE', 'DEFENCE PH 4,KARACHI PL 67C', 'DEFENCE PHASE - 4 COMM AREA'],
            ['INSAF GENERAL STORE', 'AYUB GOTH', 'ALLAH WALI BELT'],
            ['AR MART', 'Plot No A-487 Block-1 Near Abid Town Gulshan-e-Iqbal', 'GULSHAN BLK-1,KAMRAN MARKET'],
            ['M. MART', 'SHOP NO 12 P,N.T Colony', 'P.N.T COLONY'],
            ['GULSHAN SUPER STORE', 'PLOT NO.SB-16, BLK-13-B, CHIRAGH CENTRE, GULSHAN-E-IQBAL, NEAR POLICE CHOWKY', 'GULSHAN BLK-13 B'],
            ['KASHIF KARYANA STORE', 'SHOP NO.4 BLOCK NO.11  AL SYED CENTER QUAIDABAD', 'QUAIDABAD'],
            ['HUSSAINI SUPER MART', 'NORTH NAZIMABAD BLOCK-E', 'NORTH NAZIMABAD BL- E'],
            ['AL MACCA GENERAL STORE', 'GADRDEN WEST NEAR QUBA MASJID', 'GARDEN WEST (ALI BHAI AUDITORI'],
            ['Madina Mart', 'SHOP-1,NOMI ARCADE,FATIMA JINNAH COLONY JAMSHEED ROAD-3', 'FATIMA JINNAH COLONY'],
            ['TOUHEED SUPER GENERAL STORE', 'LA 90361 SEC 16 GULSHANEBIHAR ORANGI TOWN', 'GULSHAN-E-BIHAR'],
            // Add more entries as needed
        ];
        
        

        foreach ($storeData as $data) {
            Store::create([
                'name' => $data[0],
                'address' => $data[1],
                'mainaddress' => $data[2],
                'user_id' => User::inRandomOrder()->first()->id, 
            ]);
        }
    }
}

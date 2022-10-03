<?php if(!defined('BASEPATH')) exit('No direct script access allowed');



class Type_model extends Base_model
{

    public $table = "rc_rel_type";

    //set column field database for datatable orderable
    var $column_order = array(null, 'name', 'slug', 'status'); 

    //set column field database for datatable searchable 
    var $column_search = array('name'); 

    var $order = array('id' => 'asc'); // default order



        



        function __construct() {



            parent::__construct();



        }







     function delete($id) {



        $this->db->where('id', $id);



        $this->db->delete($this->table);        



        return $this->db->affected_rows();



    }







    public function find($id) {
            $query = $this->db->select('*')
                    ->from($this->table)
                    ->where('id', $id)
                    ->get();

            if ($query->num_rows() > 0) {
                $result = $query->result();
                return $result[0];
            } else {
                return array();
            }
        }

       // Get  List

        function get_datatables()
        {

            $this->_get_datatables_query();

            if(isset($_POST['length']) && $_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

            $query = $this->db->get();

            return $query->result();

        }

        // Get Database 

         public function _get_datatables_query()
        {     

            $this->db->from($this->table);

            $i = 0;     

            foreach ($this->column_search as $item) // loop column 

            {

                if(isset($_POST['search']['value']) && $_POST['search']['value']) // if datatable send POST for search

                {

                    if($i===0) // first loop

                    {

                        $this->db->like($item, $_POST['search']['value']);

                    }

                    else

                    {

                        $this->db->or_like($item, $_POST['search']['value']);

                    }

                }

                $i++;

            }

             

            if(isset($_POST['order'])) // here order processing
            {

                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

            } 

            else if(isset($this->order))

            {

                $order = $this->order;

                $this->db->order_by(key($order), $order[key($order)]);

            }

        }



        // Count  Filtered

        function count_filtered()
        {

            $this->_get_datatables_query();

            $query = $this->db->get();

            return $query->num_rows();

        }

        // Count all

        public function count_all()
        {

            $this->db->from($this->table);

            return $this->db->count_all_results();

        }
        // Category table [id, categoryid,status]
        // tyep table [id, categoryid, type,status]
        // get category list


        // public function getCategoryList(){
        //     $res= array();
        //     $res[1] = "Residential";
        //     $res[2] = "Commercial";
        //     return $res;
        // }

        
        // get type list
        public function getTypeList(){
            $type = array();
            $type[1] = "Villa";
            $type[2] = "Apartment";
            $type[3] = "Residential Floor";
            $type[4] = "Residential Plot";
            $type[5] = "Townhouse";
            $type[6] = "Residential Building";
            $type[7] = "Penthouse";
            $type[8] = "Villa Compound";
            $type[9] = "Hotel Apartment";
            $type[10] = "Office";
            $type[11] = "Shop";
            $type[12] = "Warehouse";
            $type[13] = "Factory";
            $type[14] = "Labour Camp";
            $type[15] = "Commercial Building";
            $type[16] = "Other Commercial";
            $type[17] = "Commercial Floor";
            $type[18] = "Commercial Plot";
            $type[19] = "Bulk Units";
            $type[20] = "Industrial Land";
            $type[21] = "Mixed Use Land";
            $type[22] = "Showroom";
            $type[23] = "Commercial Villa";
            return $type;
        }


        //Residential List Only Start
        public function getResidentialList(){
            $res= array();
            $res[1] = "Villa";
            $res[2] = "Apartment";
            $res[3] = "Residential Floor";
            $res[4] = "Residential Plot";
            $res[5] = "Townhouse";
            $res[6] = "Residential Building";
            $res[7] = "Penthouse";
            $res[8] = "Villa Compound";
            $res[9] = "Hotel Apartment";
            return $res;
        }
       
        //Residential List Only End

        //Commercial List Only Start
        public function getCommercialList(){
            $com= array();
            $com[10] = "Office";
            $com[11] = "Shop";
            $com[12] = "Warehouse";
            $com[13] = "Factory";
            $com[14] = "Labour Camp";
            $com[15] = "Commercial Building";
            $com[16] = "Other Commercial";
            $com[17] = "Commercial Floor";
            $com[18] = "Commercial Plot";
            $com[19] = "Bulk Units";
            $com[20] = "Industrial Land";
            $com[21] = "Mixed Use Land";
            $com[22] = "Showroom";
            $com[23] = "Commercial Villa";
            return $com;
        }
        //Commercial List Only End

        // function 
        public function getEmirateList(){
            $emirate = array();
            $emirate[1] = "Dubai";
            $emirate[2] = "Sharjah";
            $emirate[3] = "Ajman";
            $emirate[4] = "Ras Al Khaimah";
            $emirate[5] = "Umm Al Quwain";
            $emirate[6] = "Abu Dhabi";
            $emirate[7] = "Al Ain";
            $emirate[8] = "Fujairah";
            return $emirate;
        }

        // function 
        public function getCommunityList(){
            $community = array();
            $community[1] = "Dubai Marina";
            $community[2] = "Business Bay";
            $community[3] = "Jumeirah Lake Towers (JLT)";
            $community[4] = "The Villa";
            $community[5] = "Dubai Pearl";
            $community[6] = "Arabian Ranches";
            $community[7] = "Discovery Gardens";
            $community[8] = "Dubai Investment Park (DIP)";
            $community[8] = "Green Community";
            $community[10] = "The Springs";
            $community[11] = "The Greens";
            $community[12] = "The Views";
            $community[13] = "The Meadows";
            $community[14] = "Dubai Sports City";
            $community[15] = "International City";
            $community[16] = "Sheikh Zayed Road";
            $community[17] = "Dubai Silicon Oasis";
            $community[18] = "DIFC";
            $community[19] = "Culture Village";
            $community[20] = "Jumeirah Village Circle (JVC)";
            $community[21] = "Palm Jumeirah";
            $community[22] = "Palm Jebel Ali";
            $community[23] = "Dubai Waterfront";
            $community[24] = "Jumeirah Golf Estate";
            $community[25] = "Jumeirah Park";
            $community[26] = "City of Arabia";
            $community[27] = "The Gardens";
            $community[28] = "The Lagoons";
            $community[29] = "Jumeirah Beach Residence (JBR)";
            $community[30] = "Old Town";
            $community[31] = "Al Nahda";
            $community[32] = "Al Qusais";
            $community[33] = "Muhaisnah";
            $community[34] = "Mirdif";
            $community[35] = "Al Mizhar";
            $community[36] = "Al Khawaneej";
            $community[37] = "Al Twar";
            $community[38] = "Oud Al Muteena";
            $community[39] = "Al Khabisi";
            $community[40] = "Al Warqaa";
            $community[41] = "Nad Al Hamar";
            $community[42] = "Nad Shamma";
            $community[43] = "Al Rashidiya";
            $community[44] = "Umm Ramool";
            $community[45] = "Al Garhoud";
            $community[46] = "Al Buteen";
            $community[47] = "Dubai Maritime City";
            $community[48] = "Al Mina";
            $community[49] = "Al Karama";
            $community[50] = "Ras Al Khor";
            $community[51] = "Nad Al Sheba";
            $community[52] = "Bukadra";
            $community[53] = "Al Hudaiba";
            $community[54] = "Al Jafiliya";
            $community[55] = "Al Satwa";
            $community[56] = "Al Badaa";
            $community[57] = "Al Wasl";
            $community[58] = "Al Safa";
            $community[59] = "Umm Suqeim";
            $community[60] = "Umm Al Sheif";
            $community[61] = "Al Manara";
            $community[62] = "Al Quoz";
            $community[63] = "Al Sufouh";
            $community[64] = "Al Barsha";
            $community[65] = "Jumeirah Islands";
            $community[66] = "Jebel Ali";
            $community[67] = "Dubai Industrial Park";
            $community[68] = "Deira Island";
            $community[69] = "Jumeirah";
            $community[70] = "Dubailand";
            $community[71] = "Remraam";
            $community[72] = "Arjan";
            $community[73] = "Liwan";
            $community[74] = "Dubai Production City (IMPZ)";
            $community[75] = "Dubai Festival City";
            $community[76] = "Barsha Heights (Tecom)";
            $community[77] = "The World Islands";
            $community[78] = "Downtown Jebel Ali";
            $community[79] = "Dubai World Central";
            $community[80] = "Al Furjan";
            $community[81] = "Emirates Hills";
            $community[82] = "Al Barari";
            $community[83] = "The Lakes";
            $community[84] = "Deira";
            $community[85] = "Bur Dubai";
            $community[86] = "Meydan City";
            $community[87] = "Dubai Science Park";
            $community[88] = "Jumeirah Village Triangle (JVT)";
            $community[89] = "Downtown Dubai";
            $community[90] = "Al Warsan";
            $community[91] = "Motor City";
            $community[92] = "Academic City";
            $community[93] = "Dubai Promenade";
            $community[94] = "Al Mamzar";
            $community[95] = "Al Awir";
            $community[96] = "Pearl Jumeirah";
            $community[97] = "Dubai Internet City";
            $community[98] = "Dubai Media City";
            $community[99] = "Knowledge Village";
            $community[100] = "Dubai Studio City";
            $community[101] = "Reem";
            $community[102] = "Mudon";
            $community[103] = "Emirates Living";
            $community[104] = "The Hills";
            $community[105] = "Mohammad Bin Rashid City";
            $community[106] = "Dubai Hills Estate";
            $community[107] = "The Sustainable City";
            $community[108] = "Jumeirah Heights";
            $community[109] = "Town Square";
            $community[110] = "Emirates Golf Club";
            $community[111] = "Ibn Battuta Gate";
            $community[112] = "Akoya Oxygen";
            $community[113] = "Dubai South";
            $community[114] = "Al Ruwayyah";
            $community[115] = "Serena";
            $community[116] = "Dubai Airport Freezone (DAFZA)";
            $community[117] = "DAMAC Hills (Akoya by DAMAC)";
            $community[118] = "Dubai Residence Complex";
            $community[119] = "World Trade Centre";
            $community[120] = "Technology Park";
            $community[121] = "Bluewaters Island";
            $community[122] = "Arabian Ranches 2";
            $community[123] = "Dubai Harbour";
            $community[124] = "Wadi Al Safa 2";
            $community[125] = "Tilal Al Ghaf";
            $community[126] = "Dragon City";
            $community[127] = "Wasl Gate";
            $community[128] = "Arabian Ranches 3";
            $community[129] = "Mina Rashid";
            $community[130] = "Murqquab";
            $community[131] = "The Valley";
            $community[132] = "Maisan Tower";
            $community[133] = "Al Ghadeer";
            $community[134] = "Al Reem Island";
            $community[135] = "Saadiyat Island";
            return $community;
        }

        // function 
        public function getSubLocationList(){
            $subLocation = array();
            $subLocation[1][1]   = "Supreme Tower"; 
            $subLocation[1][2]   = "The Waterfront";    
            $subLocation[1][3]   = "23 Marina"; 
            $subLocation[1][4]   = "DEC Towers";    
            $subLocation[1][5]   = "The Royal Oceanic"; 
            $subLocation[1][6]   = "Trident Grand Residence";   
            $subLocation[1][7]   = "La Riviera";    
            $subLocation[1][8]   = "Elite Residence";   
            $subLocation[1][9]   = "Marina Residence";  
            $subLocation[1][10]  = "Al Atina Twin Towers";  
            $subLocation[1][11]  = "Bayside Residence"; 
            $subLocation[1][12]  = "Manchester Tower";  
            $subLocation[1][13]  = "Marina Mansions";   
            $subLocation[1][14]  = "Marina Quays East"; 
            $subLocation[1][15]  = "Marina Quays North";    
            $subLocation[1][16]  = "Marina Quays West"; 
            $subLocation[1][17]  = "Number One Dubai Marina";   
            $subLocation[1][18]  = "Panoramic"; 
            $subLocation[1][19]  = "Pier 24";   
            $subLocation[1][20]  = "Shahla Tower";  
            $subLocation[1][21]  = "The Atlantic";  
            $subLocation[1][22]  = "The Pacific";   
            $subLocation[1][23]  = "Yacht Bay"; 
            $subLocation[1][24]  = "Al Marsa Tower";    
            $subLocation[1][25]  = "Al Seef Tower"; 
            $subLocation[1][26]  = "ARY Marina View";   
            $subLocation[1][27]  = "Azure"; 
            $subLocation[1][28]  = "Emerald Residence"; 
            $subLocation[1][29]  = "Gargash Tower"; 
            $subLocation[1][30]  = "Iris Blue"; 
            $subLocation[1][31]  = "Marina Pearl";  
            $subLocation[1][32]  = "Marina Pinnacle";   
            $subLocation[1][33]  = "Marina Sail";   
            $subLocation[1][34]  = "Marinascape Avant"; 
            $subLocation[1][35]  = "Marinascape Oceanic";   
            $subLocation[1][36]  = "The Belvedere"; 
            $subLocation[1][37]  = "The Cascades";  
            $subLocation[1][38]  = "Dream Towers";  
            $subLocation[1][39]  = "The Point"; 
            $subLocation[1][40]  = "The Torch"; 
            $subLocation[1][41]  = "Al Areifi Marina";  
            $subLocation[1][42]  = "Horizon Tower"; 
            $subLocation[1][43]  = "Cayan Tower";   
            $subLocation[1][44]  = "KG Tower";  
            $subLocation[1][45]  = "La Residence Del Mar";  
            $subLocation[1][46]  = "Le Reve";   
            $subLocation[1][47]  = "Mag 218 Tower"; 
            $subLocation[1][48]  = "Marina Crown";  
            $subLocation[1][49]  = "Marina Heights Tower";  
            $subLocation[1][50]  = "Marina Terrace";    
            $subLocation[1][51]  = "Ocean Heights"; 
            $subLocation[1][52]  = "Princess Tower";    
            $subLocation[1][53]  = "The Jewels";    
            $subLocation[1][54]  = "The Waves"; 
            $subLocation[1][55]  = "Emaar 2N Tower";    
            $subLocation[1][56]  = "Marina Garden"; 
            $subLocation[1][57]  = "DAMAC Residenze";   
            $subLocation[1][58]  = "Silverene"; 
            $subLocation[1][59]  = "Marina Suites"; 
            $subLocation[1][60]  = "Marina 101";    
            $subLocation[1][61]  = "Dorrabay";  
            $subLocation[1][62]  = "Time Place";    
            $subLocation[1][63]  = "Westside Marina";   
            $subLocation[1][64]  = "The Zen";   
            $subLocation[1][65]  = "Casa Del Sol";  
            $subLocation[1][66]  = "Miramar";   
            $subLocation[1][67]  = "Emirates Crown";    
            $subLocation[1][68]  = "KPM Tower"; 
            $subLocation[1][69]  = "Zumurud Tower"; 
            $subLocation[1][70]  = "Harbour Residence"; 
            $subLocation[1][71]  = "Najd Tower";    
            $subLocation[1][72]  = "Marina Crystal";    
            $subLocation[1][73]  = "The Lighthouse";    
            $subLocation[1][74]  = "Marina Promenade";  
            $subLocation[1][75]  = "The Address Dubai Marina (Mall Hotel)"; 
            $subLocation[1][76]  = "Sulafa Tower";  
            $subLocation[1][77]  = "Marina Plaza";  
            $subLocation[1][78]  = "Botanica Tower";    
            $subLocation[1][79]  = "Marina Park";   
            $subLocation[1][80]  = "Skyview Tower"; 
            $subLocation[1][81]  = "Orra Marina";   
            $subLocation[1][82]  = "Marina Arcade"; 
            $subLocation[1][83]  = "Gulf Tower";    
            $subLocation[1][84]  = "Venti Quattro"; 
            $subLocation[1][85]  = "Lotus Hotel Apartments &amp; Spa";  
            $subLocation[1][86]  = "Casa Del Mar";  
            $subLocation[1][87]  = "Al Fardan Towers";  
            $subLocation[1][88]  = "Al Habtoor Tower";  
            $subLocation[1][89]  = "TAMANI Hotel Marina";   
            $subLocation[1][90]  = "Al Habtoor Business Tower"; 
            $subLocation[1][91]  = "Lootah Complex (Al Husn Marina)";   
            $subLocation[1][92]  = "Ariyana Tower"; 
            $subLocation[1][93]  = "Marina Opal Tower"; 
            $subLocation[1][94]  = "Dusit Residence Dubai Marina";  
            $subLocation[1][95]  = "Marina Hotel Apartments";   
            $subLocation[1][96]  = "West Avenue";   
            $subLocation[1][97]  = "Escan Marina Tower";    
            $subLocation[1][98]  = "Marina Tower";  
            $subLocation[1][99]  = "No. 9"; 
            $subLocation[1][100]     = "Al Majara"; 
            $subLocation[1][101]     = "Al Sahab Tower";    
            $subLocation[1][102]     = "Bay Central";   
            $subLocation[1][103]     = "Dubai Marina Towers (Emaar 6 Towers)";  
            $subLocation[1][104]     = "Marina View Tower"; 
            $subLocation[1][105]     = "Marina Wharf";  
            $subLocation[1][106]     = "Bunyan Tower";  
            $subLocation[1][107]     = "Sukoon Tower";  
            $subLocation[1][108]     = "Marina Gate";   
            $subLocation[1][109]     = "Grosvenor House";   
            $subLocation[1][110]     = "Al Dar Tower";  
            $subLocation[1][111]     = "InterContinental Dubai Marina"; 
            $subLocation[1][112]     = "Wyndham Dubai Marina";  
            $subLocation[1][113]     = "Al Anbar Villas";   
            $subLocation[1][114]     = "5242 Towers";   
            $subLocation[1][115]     = "Sparkle Towers";    
            $subLocation[1][116]     = "Damac Heights"; 
            $subLocation[1][117]     = "Studio One Tower";  
            $subLocation[1][118]     = "Dubai Marina Walk"; 
            $subLocation[1][119]     = "Al Shebani Residence";  
            $subLocation[1][120]     = "Continental Tower"; 
            $subLocation[1][121]     = "Vida Residences Dubai Marina";  
            $subLocation[1][122]     = "Jannah Place Dubai Marina"; 
            $subLocation[1][123]     = "Marina First Tower";    
            $subLocation[1][124]     = "Dubai Marina Mall"; 
            $subLocation[1][125]     = "Dubai Marriott Harbour Hotel &amp; Suites"; 
            $subLocation[1][126]     = "Le Royal Meridien Beach Resort &amp; Spa";  
            $subLocation[1][127]     = "Marinascape";   
            $subLocation[1][128]     = "Park Island";   
            $subLocation[1][129]     = "Marina Diamonds";   
            $subLocation[1][130]     = "City Premier Marina Hotel Apartments";  
            $subLocation[1][131]     = "Stella Maris";  
            $subLocation[1][132]     = "Marina View Hotel Apartments";  
            $subLocation[1][133]     = "Radisson Blu Residence Dubai Marina";   
            $subLocation[1][134]     = "Pier 7";    
            $subLocation[1][135]     = "Durrat Al Marsa";   
            $subLocation[1][136]     = "Marina Byblos Hotel";   
            $subLocation[1][137]     = "Marina Quays Villas";   
            $subLocation[1][138]     = "Al Mass Villas";    
            $subLocation[1][139]     = "Al Mesk Villas";    
            $subLocation[1][140]     = "Marinascape Marina Homes";  
            $subLocation[1][141]     = "LIV Residence"; 
            $subLocation[1][142]     = "Trident Bayside";   
            $subLocation[1][143]     = "TFG Marina Hotel";  
            $subLocation[1][144]     = "JAM Marina Residence";  
            $subLocation[1][145]     = "My Tower";  
            $subLocation[1][146]     = "Pier 8";    
            $subLocation[1][147]     = "Le Grande Community Mall";  
            $subLocation[1][148]     = "Al Zarooni Buildings";  
            $subLocation[1][149]     = "Signature Hotel Apartments &amp; Spa Marina";   
            $subLocation[1][150]     = "Jannah Marina Hotel Apartments";    
            $subLocation[1][151]     = "Rove Dubai Marina"; 
            $subLocation[1][152]     = "Barcelo Residences";    
            $subLocation[1][153]     = "Extreme Waterfront Offices";    
            $subLocation[1][154]     = "Nuran Marina Serviced Residences";  
            $subLocation[1][155]     = "Dusit Princess Residence";  
            return $subLocation;
        }

        function getCountNumberList(){
            $count    = array();
            $count[1] = 1; 
            $count[2] = 2; 
            $count[3] = 3; 
            $count[4] = 4; 
            $count[5] = 5; 
            $count[6] = 6; 
            $count[7] = 7; 
            $count[8] = 8; 
            $count[9] = 9; 
            $count[10] = 10; 
            $count[11] = 11; 
            $count[12] = 12; 
            return $count;
        }
        // developers
        function getDeveloperList(){
            $developer    = array();
            $developer[1] = " Azizi Developments";
            $developer[2] = " Credo Investments";
            $developer[3] = " Damac Properties";
            $developer[4] = " Mustafa bin Abdul Latif Group";
            $developer[5] = " Nakheel";
            $developer[6] = " Tameer Holding Investment LLC";
            $developer[7] = " The Developer Properties";
            $developer[8] = " Trident International Holdings";
            $developer[9] = " Zabeel Properties";
            $developer[10] = " Aber Properties";
            $developer[11] = " Bando Engineering &amp; Construction Co. Ltd";
            $developer[12] = " Business Center";
            $developer[13] = " Diamond Developers";
            $developer[14] = " Five Holdings";
            $developer[15] = " Gulf General Investments (GGICO)";
            $developer[16] = " H.H SHEIKH SUROOR BIN MOHAMMED AL NAHYAN ";
            $developer[17] = " INNOVATION SEZ DEVELOPER LTD";
            $developer[18] = " Lime Light ";
            $developer[19] = " Nakheel";
            $developer[20] = " UTMOST Properties";
            $developer[21] = " ZAYA LIVING REAL ESTATE DEVELOPMENT L.L.C";
            return $developer;
        }

        // function furnissing
        public function listFurnissing(){
            $furnissing = array();
            $furnissing[1] = "Furnished";
            $furnissing[2] = "UnFurnished";
            return $furnissing;
        }

        // function Lsm
        public function listLsm(){
            $lsm = array();
            $lsm[1] = "Shared";
            $lsm[2] = "Private";
            return $lsm;
        }

        // function Setting ManageTemplate Type
        public function listEmailTempType(){
            $temp = array();
            $temp[1] = "Description";
            $temp[2] = "Email";
            return $temp;
        }

        // function TypeOfContact
        public function listTypeOfContact(){
            $arr = array();
            $arr[1] = "Individual";
            $arr[2] = "Company";
            return $arr;
        }

        // function listState
        public function listStateIndia(){
            $listStateIndia = array();
            $listStateIndia[1] = "Delhi";
            $listStateIndia[2] = "Mumbai";
            return $listStateIndia;
        }

        // function listNationality
        public function listNationality(){
            $nationality = array();
            $nationality[1] = "United Arab Emirates";
            $nationality[2] = "United Kingdom";
            $nationality[3] = "United States of America";
            $nationality[4] = "Australia";
            $nationality[5] = "Canada";
            $nationality[6] = "Brazil";
            $nationality[7] = "Malaysia";
            $nationality[8] = "Afghanistan";
            $nationality[9] = "Albania";
            $nationality[10] = "Algeria";
            $nationality[11] = "American Samoa";
            $nationality[12] = "Andorra";
            $nationality[13] = "Angola";
            $nationality[14] = "Anguilla";
            $nationality[15] = "Antarctica";
            $nationality[16] = "Antigua and Barbuda";
            $nationality[17] = "Argentina";
            $nationality[18] = "Armenia";
            $nationality[19] = "Aruba";
            $nationality[20] = "Austria";
            $nationality[21] = "Azerbaijan";
            $nationality[22] = "Bahamas";
            $nationality[23] = "Bahrain";
            $nationality[24] = "Bangladesh";
            $nationality[25] = "Barbados";
            $nationality[26] = "Belarus";
            $nationality[27] = "Belgium";
            $nationality[28] = "Belize";
            $nationality[29] = "Benin";
            $nationality[30] = "Bermuda";
            $nationality[31] = "Bhutan";
            $nationality[32] = "Bolivia";
            $nationality[33] = "Bosnia and Herzegoviegovina";
            $nationality[34] = "Botswana";
            $nationality[35] = "Bouvet Island";
            $nationality[36] = "British Indian Ocean Territory";
            $nationality[37] = "Brunei Darussalam";
            $nationality[38] = "Bulgaria";
            $nationality[39] = "Burkina Faso";
            $nationality[40] = "Burundi";
            $nationality[41] = "Cambodia";
            $nationality[42] = "Cameroon";
            $nationality[43] = "Cape Verde";
            $nationality[44] = "Cayman Islands";
            $nationality[45] = "Central African Republic";
            $nationality[46] = "Chad";
            $nationality[47] = "Chile";
            $nationality[48] = "China";
            $nationality[49] = "Colombia";
            $nationality[50] = "Comoros";
            $nationality[51] = "Congo";
            $nationality[52] = "Cook Islands";
            $nationality[53] = "Costa Rica";
            $nationality[54] = "Cote D'Ivoire";
            $nationality[55] = "Croatia";
            $nationality[56] = "Cuba";
            $nationality[57] = "Cyprus";
            $nationality[58] = "Czech Republic";
            $nationality[59] = "Denmark";
            $nationality[60] = "Djibouti";
            $nationality[61] = "Dominica";
            $nationality[62] = "Dominican Republic";
            $nationality[63] = "Ecuador";
            $nationality[64] = "Egypt";
            $nationality[65] = "El Salvador";
            $nationality[66] = "Equatorial Guinea";
            $nationality[67] = "Eritrea";
            $nationality[68] = "Estonia";
            $nationality[69] = "Ethiopia";
            $nationality[70] = "Falkland Islands (Malvinas)";
            $nationality[71] = "Faroe Islands";
            $nationality[72] = "Fiji";
            $nationality[73] = "Finland";
            $nationality[74] = "France";
            $nationality[75] = "French Guiana";
            $nationality[76] = "French Polynesia";
            $nationality[77] = "French Southern Terri Territories";
            $nationality[78] = "Gabon";
            $nationality[79] = "Gambia";
            $nationality[80] = "Georgia";
            $nationality[81] = "Germany";
            $nationality[82] = "Ghana";
            $nationality[83] = "Gibraltar";
            $nationality[84] = "Greece";
            $nationality[85] = "Greenland";
            $nationality[86] = "Grenada";
            $nationality[87] = "Guadeloupe";
            $nationality[88] = "Guam";
            $nationality[89] = "Guatemala";
            $nationality[90] = "Guinea";
            $nationality[91] = "Guinea-Bissau";
            $nationality[92] = "Guyana";
            $nationality[93] = "Haiti";
            $nationality[94] = "Heard Island and McDand and McDonald Islands";
            $nationality[95] = "Holy See (Vatican Citan City State)";
            $nationality[96] = "Honduras";
            $nationality[97] = "Hong Kong";
            $nationality[98] = "Hungary";
            $nationality[99] = "Iceland";
            $nationality[100] = "India";
            $nationality[101] = "Indonesia";
            $nationality[102] = "Iran";
            $nationality[103] = "Iraq";
            $nationality[104] = "Ireland";
            $nationality[105] = "Italy";
            $nationality[106] = "Jamaica";
            $nationality[107] = "Japan";
            $nationality[108] = "Jordan";
            $nationality[109] = "Kazakstan";
            $nationality[110] = "Kenya";
            $nationality[111] = "Kiribati";
            $nationality[112] = "Korea";
            $nationality[113] = "Kuwait";
            $nationality[114] = "Kyrgyzstan";
            $nationality[115] = "Latvia";
            $nationality[116] = "Lebanon";
            $nationality[117] = "Lesotho";
            $nationality[118] = "Liberia";
            $nationality[119] = "Libyan Arab Jamahiriahiriya";
            $nationality[120] = "Liechtenstein";
            $nationality[121] = "Lithuania";
            $nationality[122] = "Luxembourg";
            $nationality[123] = "Macau";
            $nationality[124] = "Macedonia";
            $nationality[125] = "Madagascar";
            $nationality[126] = "Malawi";
            $nationality[127] = "Maldives";
            $nationality[128] = "Mali";
            $nationality[129] = "Malta";
            $nationality[130] = "Marshall Islands";
            $nationality[131] = "Martinique";
            $nationality[132] = "Mauritania";
            $nationality[133] = "Mauritius";
            $nationality[134] = "Mayotte";
            $nationality[135] = "Mexico";
            $nationality[136] = "Micronesia";
            $nationality[137] = "Moldova";
            $nationality[138] = "Monaco";
            $nationality[139] = "Mongolia";
            $nationality[140] = "Montserrat";
            $nationality[141] = "Morocco";
            $nationality[142] = "Mozambique";
            $nationality[143] = "Myanmar";
            $nationality[144] = "Namibia";
            $nationality[145] = "Nauru";
            $nationality[146] = "Nepal";
            $nationality[147] = "Netherlands";
            $nationality[148] = "Netherlands Antilles";
            $nationality[149] = "New Caledonia";
            $nationality[150] = "New Zealand";
            $nationality[151] = "Nicaragua";
            $nationality[152] = "Niger";
            $nationality[153] = "Nigeria";
            $nationality[154] = "Norfolk Island";
            $nationality[155] = "Northern Mariana Islands";
            $nationality[156] = "Norway";
            $nationality[157] = "Oman";
            $nationality[158] = "Pakistan";
            $nationality[159] = "Palau";
            $nationality[160] = "Palestine";
            $nationality[161] = "Panama";
            $nationality[162] = "Papua New Guinea";
            $nationality[163] = "Paraguay";
            $nationality[164] = "Peru";
            $nationality[165] = "Philippines";
            $nationality[166] = "Poland";
            $nationality[167] = "Portugal";
            $nationality[168] = "Puerto Rico";
            $nationality[169] = "Qatar";
            $nationality[170] = "Reunion";
            $nationality[171] = "Romania";
            $nationality[172] = "Russian Federation";
            $nationality[173] = "Rwanda";
            $nationality[174] = "Saint Kitts and Nevis";
            $nationality[175] = "Saint Lucia";
            $nationality[176] = "Saint Vincent and the Grenadines";
            $nationality[177] = "Samoa";
            $nationality[178] = "San Marino";
            $nationality[179] = "Sao Tome and Principe";
            $nationality[180] = "Saudi Arabia";
            $nationality[181] = "Senegal";
            $nationality[182] = "Seychelles";
            $nationality[183] = "Sierra Leone";
            $nationality[184] = "Singapore";
            $nationality[185] = "Slovakia";
            $nationality[186] = "Slovenia";
            $nationality[187] = "Solomon Islands";
            $nationality[188] = "Somalia";
            $nationality[189] = "South Africa";
            $nationality[190] = "Spain";
            $nationality[191] = "Sri Lanka";
            $nationality[192] = "Sudan";
            $nationality[193] = "Suriname";
            $nationality[194] = "Swaziland";
            $nationality[195] = "Sweden";
            $nationality[196] = "Switzerland";
            $nationality[197] = "Syrian Arab Republic";
            $nationality[198] = "Taiwan";
            $nationality[199] = "Tajikistan";
            $nationality[200] = "Tanzania";
            $nationality[201] = "Thailand";
            $nationality[202] = "Togo";
            $nationality[203] = "Tokelau";
            $nationality[204] = "Tonga";
            $nationality[205] = "Trinidad and Tobago";
            $nationality[206] = "Tunisia";
            $nationality[207] = "Turkey";
            $nationality[208] = "Turkmenistan";
            $nationality[209] = "Turks and Caicos Islands";
            $nationality[210] = "Tuvalu";
            $nationality[211] = "Uganda";
            $nationality[212] = "Ukraine";
            $nationality[213] = "United States Minor Outlying Islands";
            $nationality[214] = "Uruguay";
            $nationality[215] = "Uzbekistan";
            $nationality[216] = "Vanuatu";
            $nationality[217] = "Venezuela";
            $nationality[218] = "Vietnam";
            $nationality[219] = "Virgin Islands";
            $nationality[220] = "Virgin Islands";
            $nationality[221] = "Wallis and Futuna";
            $nationality[222] = "Yemen";
            $nationality[223] = "Yugoslavia";
            $nationality[224] = "Zambia";
            $nationality[225] = "Zimbabwe";

            return $nationality;
        }

        // function secoure
        public function listSecure(){
            $secure = array();
            $secure[1] = "Not Specified";
            $secure[2] = "Whatsapp";
            $secure[3] = "Personal Referral";
            $secure[4] = "Bank Referral";
            $secure[5] = "Client Referral";
            $secure[6] = "Referral within company";
            $secure[7] = "Open House";
            $secure[8] = "Direct Call";
            $secure[9] = "Walk-in";
            $secure[10] = "Online Banners";
            $secure[11] = "Outdoor Media";
            $secure[12] = "Exhibition Stand";
            $secure[13] = "Existing Client";
            $secure[14] = "Email Campaign";
            $secure[15] = "SMS Campaign";
            $secure[16] = "Flyers";
            $secure[17] = "Roadshow";
            $secure[18] = "Radio";
            $secure[19] = "Business Card";
            $secure[20] = "Word of Mouth";
            $secure[21] = "Newspaper advert";
            $secure[22] = "Magazine advert";
            $secure[23] = "Newsletter";
            $secure[24] = "Cold call";
            $secure[25] = "Google";
            $secure[26] = "Other";
            $secure[27] = "Listing Sharing Manager (LSM)";
            $secure[28] = "Dubizzle.com";
            $secure[29] = "Propertyfinder.ae";
            $secure[30] = "JustProperty.com";
            $secure[31] = "Other portal";
            $secure[32] = "Company website";
            $secure[33] = "Zoopla.co.uk";
            $secure[34] = "Rightmove.co.uk";
            $secure[35] = "Propertywifi.com";
            $secure[36] = "Simsari";
            $secure[37] = "Facebook";
            $secure[38] = "Youtube";
            $secure[39] = "whatsapp";
            $secure[40] = "Linkedin";
            $secure[41] = "Instagram";
            $secure[42] = "Twitter";
            $secure[43] = "Gulf News";
            $secure[44] = "Khaleej Times";
            $secure[45] = "IBPC";
            $secure[46] = "CFA";
            $secure[47] = "Bayut.com (Email Lead)";
            $secure[48] = "Property Management Services";
            $secure[49] = "Developer";
            return $secure;

        }

        // function assign
        public function listAssignTo(){
            $list = array();
            $list[1] = "Waseem Abidi";
            $list[2] = "Parveez Ahmad";
            $list[3] = "abbas";
            $list[4] = "Saleem Abidi";
            $list[5] = "Faizan Sheikh";
            $list[6] = "Shahroze";
            $list[7] = "Nouman";
            $list[8] = "Sayed";
            $list[9] = "Muhammad";
            $list[10] = "Shujaat";
            $list[11] = "Bhoomi";
            $list[12] = "Adnan Chaudhry";
            $list[13] = "Abdul";
            $list[14] = "Abdul Latif";
            $list[15] = "Apollinaria Arafa";
            $list[16] = "Pernekul Aitbayea";
            $list[17] = "Ahmed Latif";
            $list[18] = "Shayan";
            return $list;

        }

        // function listPropertyStatus
        public function listPropertyStatus(){
            $list = array();
            $list[1] = "Draft";
            $list[2] = "Live";
            $list[3] = "Archive";
            $list[4] = "Review";
            return $list;

        }

         // function listFrequency
        public function listFrequency(){
            $list = array();
            $list[1] = "Yearly";
            $list[2] = "Monthly";
            $list[3] = "Weekly";
            $list[4] = "Daily";
            return $list;

        }

        // function listFeatureStatus
        public function listFeatureStatus(){
            $list = array();
            $list[1] = "Never Lived In";
            $list[2] = "Featured on company website";
            $list[3] = "Exclusive Rights";
            return $list;

        }

        // function InstantEmails
        public function instantEmail(){
            $email = array();
            $email[1] = "Listing Assigned";
            $email[2] = "Lead Assigned";
            $email[3] = "Listing Approval";
            $email[4] = "Task Assigned";
            $email[5] = "Listing Approved";
            $email[6] = "Listing Rejected";
            $email[7] = "LSM Lead";
            $email[8] = "Email Lead";
            return $email;

        }

        // function EmailReminderList
        public function reminderEmail(){
            $reminder = array();
            $reminder[1] = "Task Reminder";
            $reminder[2] = "Tenancy Expiry";
            return $reminder;

        }

        // function listCheques
        public function listCheques(){
            $list = array();
            $list[1] = "1 cheque (Yearly)";
            $list[2] = "2 cheques (Bi-Yearly)";
            $list[3] = "3 cheques (Triannual)";
            $list[4] = "4 cheques (Quarterly)";
            $list[5] = "6 cheques (Bi-Monthly )";
            $list[6] = "12 cheques (Monthly)";
            return $list;

        }

        // function RecreationAndFamily
        public function RecreationAndFamily(){
            $list = array();
            $list[1] = "Barbeque Area";
            $list[2] = "Day Care Center";
            $list[3] = "Kids Play Area";
            $list[4] = "Lawn or Garden";
            $list[5] = "Cafeteria or Canteen";
            return $list;
        }

        // function HealthAndFitness
        public function HealthAndFitness(){
            $list = array();
            $list[1] = "First Aid Medical Center";
            $list[2] = "Gym or Health Club";
            $list[3] = "Jacuzzi";
            $list[4] = "Sauna";
            $list[5] = "Steam Room";
            $list[6] = "Swimming Pool";
            $list[7] = "Facilities for Disabled";
            return $list;
        }

        // function LaundryAndKitchen
        public function LaundryAndKitchen(){
            $list = array();
            $list[1] = "Laundry Room";
            $list[2] = "Laundry Facility";
            $list[3] = "Shared Kitchen";
            return $list;
        }

        // function LaundryAndKitchen
        public function BuildingList(){
            $list = array();
            $list[1] = "Balcony or Terrace";
            $list[2] = "Lobby in Building";
            $list[3] = "Service Elevators";
            $list[4] = "Prayer Room";
            $list[5] = "Reception/Waiting Room";
            return $list;
        }

        // function FlooringList
        public function FlooringList(){
            $list = array();
            $list[1] = "Tiels";
            $list[2] = "Marble";
            return $list;
        }

        // function BusinessAndSecurity
        public function BusinessAndSecurity(){
            $list = array();
            $list[1] = "Business Center";
            $list[2] = "Conference Room";
            $list[3] = "Security Staff";
            $list[4] = "CCTV Security";
            return $list;
        }

        // function MiscellaneousList
        public function MiscellaneousList(){
            $list = array();
            $list[1] = "Freehold";
            $list[2] = "ATM Facility";
            $list[3] = "Maids Room";
            $list[4] = "24 Hours Concierge";
            return $list;
        }
        // function MiscellaneousStatusList
        public function PetPolicy(){
            $list = array();
            $list[1] = "Allowed";
            $list[2] = "NotAllowed";
            return $list;
        }

        // function TechnologyList
        public function TechnologyList(){
            $list = array();
            $list[1] = "Broadband Internet";
            $list[2] = "Satellite/Cable TV";
            $list[3] = "Intercom";
            return $list;
        }
        // function FeaturesList
        public function FeaturesList(){
            $list = array();
            $list[1] = "Double Glazed Windows";
            $list[2] = "Centrally Air-Conditioned";
            $list[3] = "Central Heating";
            $list[4] = "Electricity Backup";
            $list[5] = "Furnished";
            $list[6] = "Storage Areas";
            $list[7] = "Study Room";
            return $list;
        }
         // function CleaningAndMaintenanceList
        public function CleaningAndMaintenanceList(){
            $list = array();
            $list[1] = "Waste Disposal";
            $list[2] = "Maintenance Staff";
            $list[3] = "Cleaning Services";
            return $list;
        }

          // function VideoHostListing
        public function VideoHostList(){
            $list = array();
            $list[1] = "YouTube";
            $list[2] = "Facebook";
            $list[3] = "Vimeo";
            $list[4] = "Dailymotion";
            return $list;
        }

         // function PortalsList
        public function PortalsList(){
            $list = array();
            $list[1] = "Bayut";
            $list[2] = "Company Website";
            $list[3] = "Dubizzle";
            $list[4] = "Generic";
            return $list;
        }

         // function SalutaionList
        public function SalutaionList(){
            $list = array();
                 
            $list[1]    = "Mr.";
            $list[2]    = "Mrs.";
            $list[3]    = "Miss.";
            $list[4]    = "Dr.";
            $list[5]    = "Ms.";
            $list[6]    = "Prof.";
            return $list;
        }

        // function PurooseList
        public function PurposeList(){
            $list = array();
                 
            $list[1]    = "Rent";
            $list[2]    = "Sale";
            return $list;
        }

         // function PurooseList
        public function RoleList(){
            $list = array();
                 
            $list[1]    = "Enquirier";
            $list[2]    = "Seller";
            $list[3]    = "Admin";
            
            return $list;
        }

 // function listPropertyStatus
        public function listContactStatus(){
            $list = array();
            $list[1] = "Draft";
            $list[2] = "Live";
            $list[3] = "Archive";
            $list[4] = "Review";
            return $list;

        }


        // function LeadPurooseList
        public function LeadPurposeList(){
            $list = array();
                 
            $list[1]    = "Buy";
            $list[2]    = "Rent";
            return $list;
        }

         // function LeadPurooseList
        public function ActiveInactiveList(){
            $list = array();
                 
            $list[1]    = "Active";
            $list[2]    = "In-Active";
            return $list;
        }


         // function NoticationLists
        public function NotificationList(){
            $notify = array();
                 
            $notify[1]    = "Property Notification";
            $notify[2]    = "SalesPipeline Notification";
            $notify[3]    = "Activity Task Notification";
            $notify[4]    = "Agency Notification";
            $notify[5]    = "Settings Notification";
            return $notify;
        }


         
           

        
          
}

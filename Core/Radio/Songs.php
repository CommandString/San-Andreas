<?php

namespace Core\Radio;

/** @internal */
class Songs
{
    private array $songs;

    public function __construct(RadioStation $station)
    {
        $this->songs = self::getAllSongs($station->id);
    }

    /** @return Song[] */
    public function getSongs(): array
    {
        return $this->songs;
    }

    public function getByTimestamp(int $timestamp): ?Song
    {
        foreach ($this->songs as $song) {
            if ($timestamp === $song->timestamp) {
                return $song;
            }
        }

        return null;
    }

    public static function getAllSongs(int $id = 0): array
    {
        $songs = [
            RadioStation::RADIO_LOS_SANTOS => [
                //       ARTIST                             NAME                                                        TIMESTAMP
                new Song('Dr Dre', 'F*** Wit Dre Dre', 25),
                new Song('Ice Cube', 'Check Yo Self', 275),
                new Song('Too $hort', 'The Ghetto', 493),
                new Song('Above The Law', 'Murder Rap', 721),
                new Song("Compton's Most Wanted", 'Hood Took Me Under', 985),
                new Song('N.W.A', 'Express Yourself', 1192),
                new Song('The D.O.C.', "It's Funky Enough", 1446),
                new Song('Da Lench Mob', 'Guerillas in tha Mist', 1684),
                new Song('Cypress Hill', 'How I Could Just Kill a Man', 1878),
                new Song('Dr. Dre & Snoop Dogg', 'Deep Cover', 2135),
                new Song('Ice Cube', 'It Was A Good Day', 2379),
                new Song('N.W.A', "Alwayz Into Somethin'", 2580),
                new Song('Dr. Dre & Snoop Dogg', "Nuthin' But a \"G\" Thang", 2807),
                new Song('2pac & Pogo', "I Don't Give a F***", 3034),
                new Song('Eazy-E', 'Eazy-Er Said Than Dunn', 3279),
                new Song('Kid Frost', 'La Raza', 3512),
            ],
            RadioStation::PLAYBACK_FM => [
                new Song('Masta Ace', 'Me and the Biz', 20),
                new Song('Eric B. & Rakim', 'I Know You Got Soul', 307),
                new Song('Spoonie Gee', 'The Godfather', 584),
                new Song('Big Daddy Kane', 'Warm It Up, Kane', 809),
                new Song('Kool G Rap & DJ Polo', 'Road To The Riches', 995),
                new Song('Public Enemy', 'Rebel Without a Pause', 1272),
                new Song('Rob Base and DJ E-Z Rock', 'It Takes Two', 1526),
                new Song('Gang Starr', 'B.Y.S.', 1751),
                new Song('Ultramagnetic MCs', 'Critical Beatdown', 1933),
                new Song('Biz Markie', 'The Vapors', 2141),
                new Song('Brand Nubian', 'Brand Nubian', 2434),
                new Song('Slick Rick', "Children's Story", 2647),
            ], RadioStation::K_DST => [
                new Song('Foghat', 'Slow Ride', 13),
                new Song('Creedence Clearwater Revival', 'Green River', 210),
                new Song('Heart', 'Barracuda', 364),
                new Song('Kiss', 'Strutter', 566),
                new Song('Toto', 'Hold The Line ', 782),
                new Song('Rod Stewart', 'Young Turks', 1010),
                new Song('Tom Petty', "Ruunin' Down A Dream", 1279),
                new Song('Joe Cocker', 'Woman to Woman ', 1543),
                new Song('Humble Pie', 'Get Down To It', 1780),
                new Song('Grand Funk Railroad', 'Some Kinf Of Wonderful', 1999),
                new Song('Lynyrd Skynyrd', 'Free Bird', 2215),
                new Song('America', 'A Horse With No name ', 2585),
                new Song('The Who', 'Eminence Front', 2814),
                new Song('Boston', "Smokin'", 3078),
                new Song('David Bowie', 'Somebody Up There Likes Me ', 3301),
                new Song('Eddie Money', '2 Tickets To Paradise ', 3548),
                new Song('Billy Idol', 'White Wedding', 3772),
            ],
            RadioStation::K_ROSE => [
                new Song('Desert Rose Band', 'One Step Forward', 15),
                new Song('Whitney Shafer', 'All my exes live in Texas', 246),
                new Song('Statler Brothers', 'New York City', 516),
                new Song('Jerry Reed', 'Amon Moses', 745),
                new Song('Statler Brothers', 'Bed of Roses', 958),
                new Song('Ed Bruce', "Mamas don't let your babies grow up to be cowboys", 1161),
                new Song('Juice Newton', 'Queen of hearts', 1431),
                new Song('Asleep at the Wheel', 'The letter that Johnny Walker read', 1655),
                new Song('Patsy Cline', 'Three Cigarettes in the astray', 1920),
                new Song('Merle Hagard', 'Always wanting you', 2131),
                new Song('Willie Nelson', 'Crazy', 2367),
                new Song('Alan Jackson', 'Louisiana woman, Mississippi man', 2677),
                new Song('Eddie Rabbit', 'I love the rainy night', 2882),
                new Song('Mickey Gillie', 'Make the World go away', 3111),
                new Song('Hank Williams', "Hey good lookin'", 3333),
            ],
            RadioStation::BOUNCE_FM => [
                new Song('Let it Whip', 'Dazz Band', 13),
                new Song('Yum Yum (Gimme Some)', 'Fatback Band', 230),
                new Song('You Dropped a Bomb on Me', 'Gap Band', 438),
                new Song('Hollywood Swinging', 'Kool & The Gang', 687),
                new Song('Candy', 'Cameo', 901),
                new Song('Love is the Message', 'MFSB', 1120),
                new Song('Odyssey', 'Johnny Harris', 1338),
                new Song('Running Away', 'Roy Ayers', 1632),
                new Song('Love Rollercoaster', 'The Ohio Players', 1831),
                new Song('Between the Sheets', 'The Isley Brothers', 2016),
                new Song('I Can Make You Dance', 'Zapp', 2285),
                new Song('Cold Blooded', 'Rick James', 2508),
                new Song('West Coast Poplock', 'Ronnie Hudson & The Street People', 2773),
                new Song('Loopzilla', 'George Clinton', 3008),
                new Song('Funky Worm', 'The Ohio Players', 3259),
                new Song('Twilight', 'Maze', 3425),
                new Song('Fantastic Voyage', 'Lakeside', 3669),
            ],
            RadioStation::SF_UR => [
                new Song('Jomanda', 'Make My Body Rock', 13),
                new Song('808 State', 'Pacific', 260),
                new Song('The Todd Terry Project', 'Weekend', 442),
                new Song('Nightwriters', 'Let The Music Use You', 677),
                new Song('Marshall Jefferson', 'Move Your Body', 963),
                new Song('Maurice', 'This Is Acid', 1228),
                new Song('Mr. Fingers', 'Can You Feel It?', 1436),
                new Song('A Guy Called Gerald', 'Voodoo Ray', 1674),
                new Song('Cultural Vibe', 'Ma Foom Bey', 1902),
                new Song('Ce Ce Rogers', 'Someday', 2183),
                new Song('Robert Owens', "I'll Be Your Friend", 2443),
                new Song('Frankie Knuckles', 'Your Love', 2742),
                new Song('Joe Smooth', 'Promised Land', 2991),
                new Song('Raze', 'Break 4 Love', 3173),
                new Song('Fallout', 'The Morning After', 3402),
                new Song('28th Street Crew', 'I Need A Rhythm', 3658),
            ],
            RadioStation::RADIO_X => [
                new Song("Jane's Addiction", 'Been Caught Stealing', 26),
                new Song('Living Colour', 'Cult Of Personality (cannot be played due to copy right)', 342),
                new Song('The Stone Roses', 'Fools Gold', 534),
                new Song('Ozzy Osbourne', 'Hellraiser (cannot be played due to copy right)', 804),
                new Song('Danzig', 'Mother', 1053),
                new Song('Rage Against The Machine', 'Killing in the name ', 1408),
                new Song('Faith No More', 'Midlife Crisis', 1691),
                new Song('Primal Scream', "Movin' on Up", 1890),
                new Song('Depeche Mode', 'Personal Jesus (cannot be played due to copy right)', 2069),
                new Song('L7', "Pretend We're Dead", 2326),
                new Song('Stone Temple Pilots', 'Plush', 2553),
                new Song('Soundgarden', 'Rusty Cage', 2791),
                new Song('Alice In Chains', 'Them Bones', 3159),
                new Song('Helmet', 'Unsung', 3314),
                new Song("Guns N'Roses", 'Welcome To The Jungle', 3571),
            ],
            RadioStation::CSR_103_9 => [
                new Song('Bobby Brown', "Don't Be Cruel", 13),
                new Song('Wreckx-n-Effect', 'New Jack Swing', 260),
                new Song('Today', 'I Got the Feeling', 467),
                new Song('SWV', "I'm So Into You", 702),
                new Song('Boyz II Men', 'Motownphilly', 909),
                new Song('Soul II Soul', "Keep On Movin'", 1131),
                new Song('Bell Biv DeVoe', 'Poison', 1357),
                new Song('Guy', 'Groove Me', 1554),
                new Song('Johnny Gill', 'Rub You the Right Way (remix)', 1782),
                new Song('Samuelle', 'So You Like What You See', 1986),
                new Song('Aaron Hall', "Don't Be Afraid", 2162),
                new Song('En Vogue', "My Lovin' (You're Never Gonna Get It)", 2370),
                new Song('Ralph Tresvant', 'Sensitivity', 2634),
            ],
            RadioStation::K_JAH_WEST => [
                new Song('Black Harmony', "Don't Let It Go To Your Head", 0),
                new Song('Blood Sisters', 'Ring My Bell', 251),
                new Song('Shabba Ranks', 'Wicked Inna Bed', 473),
                new Song('Buju Banton', 'Batty Rider', 667),
                new Song('Augustus Pablo', 'King Tubby Meets The Rockers Uptown', 924),
                new Song('Dennis Brown', 'Revolution', 1074),
                new Song('Willi Williams', 'Armagideon Time', 1329),
                new Song('I Roy', 'Sidewalk Killers', 1498),
                new Song('Toots and the Maytals', 'Funky Kingston', 1850),
                new Song('Dillinger', 'Cocaine In My Brain', 2066),
                new Song('The Maytals', 'Pressure Drop', 2271),
                new Song('Pliers', 'Bam Bam', 2550),
                new Song('Barrington Levy', 'Here I Come', 2804),
                new Song('Reggie Stepper', 'Drum Pan Sound', 3013),
                new Song('Black Uhuru', 'Great Train Robbery', 3340),
                new Song('Max Romeo', 'Chase The Devil', 3569),
            ],
            RadioStation::MASTER_SOUNDS_98_3 => [
                new Song('Cross the Tracks', 'Maceo & The Macks', 25),
                new Song('Express Yourself', 'Charles Wright', 300),
                new Song('Nautilus', 'Bob James', 550),
                new Song('Lowrider', 'War', 851),
                new Song('I Know You Got Soul', 'Bobby Byrd', 1080),
                new Song('Rock Creek Park', 'The Blackbyrds', 1384),
                new Song('Funky President', 'James Brown', 1694),
                new Song('Jungle Fever', 'The Chakachas', 1979),
                new Song('The Grunt', "The J.B's", 2260),
                new Song('Green Onions', "Booker T and the MG's ", 2490),
                new Song('The Payback', 'James Brown', 2738),
                new Song('So Much Trouble in Your Mind', 'Sir Joe Quarterman & Free Soul', 3032),
                new Song('Rock Me Again & Again', 'Lyn Collins', 3299),
                new Song('1:01:57 Tainted Love', 'Gloria Jones', 3596),
                new Song('1:06:10 Think', 'Lyn Collins', 3775),
                new Song('1:09:31 Hot Pants', 'Bobby Byrd', 4028),
                new Song('1:14:28 Smokin Cheeba Cheeba', 'Harlem Underground Band', 4208),
                new Song('1:19:21 Soul Power 74', 'Maceo & The Macks', 4538),
            ],
            RadioStation::WCTR => [
                new Song('Area 53 01', 'Unknown', 11),
                new Song('WCTR News 01', 'Unknown', 201),
                new Song('The Tight End Zone 01', 'Unknown', 341),
                new Song('Entertaining America 01', 'Unknown', 716),
                new Song('WCTR News 02', 'Unknown', 1083),
                new Song('Gardening with Maurice 01', 'Unknown', 1243),
                new Song('Lonely Hearts Show 01', 'Unknown', 1458),
                new Song('I Say / You Say 01', 'Unknown', 1814),
                new Song('WCTR News 03', 'Unknown', 2166),
                new Song('The Wild Traveler 01', 'Unknown', 2411),
                new Song('WCTR News 04', 'Unknown', 2753),
                new Song('Gardening with Maurice 02', 'Unknown', 2883),
                new Song('Lonely Hearts Show 02', 'Unknown', 3147),
                new Song('WCTR News 05', 'Unknown', 3347),
                new Song('Entertaining America 02', 'Unknown', 3639),
                new Song('WCTR News 06', 'Unknown', 3978),
                new Song('Gardening with Maurice 03', 'Unknown', 4126),
                new Song('Area 53 02', 'Unknown', 4218),
                new Song('The Wild Traveler 02', 'Unknown', 4427),
                new Song('WCTR News 07', 'Unknown', 4790),
                new Song('The Tight End Zone 02', 'Unknown', 4931),
                new Song('WCTR News 08', 'Unknown', 5263),
                new Song('Area 53 03', 'Unknown', 5456),
                new Song('I Say / You Say 02', 'Unknown', 5707),
                new Song('WCTR News 09', 'Unknown', 5990),
                new Song('Entertaining America 03', 'Unknown', 6048),
                new Song('WCTR News 10', 'Unknown', 6521),
                new Song('Lonely Hearts Show 03', 'Unknown', 6615),
                new Song('Gardening with Maurice 04', 'Unknown', 6954),
                new Song('WCTR News 11', 'Unknown', 7356),
            ],
        ];

        return ($id !== 0) ? $songs[$id] : $songs;
    }
}

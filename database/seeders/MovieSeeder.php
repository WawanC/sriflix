<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private array $dummy_movies = [
        [
            "title" => "Jaws",
            "genre" => ["action", "adventure"],
            "description" => "When a young woman is killed by a shark while skinny-dipping near the New England tourist town of Amity Island, police chief Martin Brody (Roy Scheider) wants to close the beaches, but mayor Larry Vaughn (Murray Hamilton) overrules him, fearing that the loss of tourist revenue will cripple the town. Ichthyologist Matt Hooper (Richard Dreyfuss) and grizzled ship captain Quint (Robert Shaw) offer to help Brody capture the killer beast, and the trio engage in an epic battle of man vs. nature.",
            "picture_url" => "https://s3.amazonaws.com/nightjarprod/content/uploads/sites/192/2021/05/10145225/l1yltvzILaZcx2jYvc5sEMkM7Eh.jpg",
            "video_url" => "https://www.youtube.com/embed/U1fu_sA7XhE?si=J_0HqQI5kSNyImAf"
        ],
        [
            "title" => "Moana",
            "genre" => ["kids", "comedy"],
            "description" => "An adventurous teenager sails out on a daring mission to save her people. During her journey, Moana meets the once-mighty demigod Maui, who guides her in her quest to become a master way-finder. Together they sail across the open ocean on an action-packed voyage, encountering enormous monsters and impossible odds. Along the way, Moana fulfills the ancient quest of her ancestors and discovers the one thing she always sought: her own identity.",
            "picture_url" => "https://lumiere-a.akamaihd.net/v1/images/p_moana_20530_214883e3.jpeg",
            "video_url" => "https://www.youtube.com/embed/LKFuXETZUsI?si=4LWeBd6n6EY7TFVB"
        ],
        [
            "title" => "Spider-man",
            "genre" => ["action", "superhero"],
            "description" => "Spider-Man centers on student Peter Parker (Tobey Maguire) who, after being bitten by a genetically-altered spider, gains superhuman strength and the spider-like ability to cling to any surface. He vows to use his abilities to fight crime, coming to understand the words of his beloved Uncle Ben: With great power comes great responsibility.",
            "picture_url" => "https://flxt.tmsimg.com/assets/p13222290_b_v9_ad.jpg",
            "video_url" => "https://www.youtube.com/embed/t06RUxPbp_c?si=t-W_ahfmLCVVaArG"
        ]
    ];

    public function run(): void
    {
        foreach ($this->dummy_movies as $movie) {

            $genreIds = [];
            foreach ($movie['genre'] as $gName) {
                $genre = Genre::where(['name' => $gName])->first();
                if (!$genre) continue;
                $genreIds[] = $genre['id'];
            }

            Movie::create([
                "title" => $movie['title'],
                "description" => $movie['description'],
                'picture_url' => $movie['picture_url'],
                "video_url" => $movie['video_url'],
            ])->genres()->attach($genreIds);
        }
    }
}

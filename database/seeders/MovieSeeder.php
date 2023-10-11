<?php

namespace Database\Seeders;

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
            "description" => "When a young woman is killed by a shark while skinny-dipping near the New England tourist town of Amity Island, police chief Martin Brody (Roy Scheider) wants to close the beaches, but mayor Larry Vaughn (Murray Hamilton) overrules him, fearing that the loss of tourist revenue will cripple the town. Ichthyologist Matt Hooper (Richard Dreyfuss) and grizzled ship captain Quint (Robert Shaw) offer to help Brody capture the killer beast, and the trio engage in an epic battle of man vs. nature.",
            "video_url" => "https://www.youtube.com/watch?v=U1fu_sA7XhE"
        ],
        [
            "title" => "Moana",
            "description" => "An adventurous teenager sails out on a daring mission to save her people. During her journey, Moana meets the once-mighty demigod Maui, who guides her in her quest to become a master way-finder. Together they sail across the open ocean on an action-packed voyage, encountering enormous monsters and impossible odds. Along the way, Moana fulfills the ancient quest of her ancestors and discovers the one thing she always sought: her own identity.",
            "video_url" => "https://www.youtube.com/watch?v=LKFuXETZUsI"
        ],
        [
            "title" => "Spider-man",
            "description" => "Spider-Man centers on student Peter Parker (Tobey Maguire) who, after being bitten by a genetically-altered spider, gains superhuman strength and the spider-like ability to cling to any surface. He vows to use his abilities to fight crime, coming to understand the words of his beloved Uncle Ben: With great power comes great responsibility.",
            "video_url" => "https://www.youtube.com/watch?v=t06RUxPbp_c"
        ]
    ];

    public function run(): void
    {
        foreach ($this->dummy_movies as $movie) {
            Movie::create($movie);
        }
    }
}

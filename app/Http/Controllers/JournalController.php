<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JournalController extends Controller
{
    protected $journal1 = [
        'title' => 'Journal 1',
        'description' => 'A journal for friends',
        'cover_url' => '/img/cover1.jpg',
        'participants' => [
            ['name' => 'Bobby Bob'],
            ['name' => 'Bobbert Bob'],
            ['name' => 'Bonnie Bobbington'],
            ['name' => 'Boris Bobford']
        ]
    ];

    protected $journal2 = [
        'title' => 'Journal 2',
        'description' => 'A journal for family',
        'cover_url' => '/img/cover1.jpg',
        'participants' => [
            ['name' => 'Bobby Bob'],
            ['name' => 'Billy Bobbly'],
            ['name' => 'Bongo Bor']
        ]
    ];

    protected $journal3 = [
        'title' => 'Journal 3',
        'description' => 'A journal for everybody!',
        'cover_url' => '/img/cover1.jpg',
        'participants' => [
        ]
    ];

    public function index() {
        return view('journal.index', ['journals' => [$this->journal1, $this->journal2, $this->journal3]]);
    }

    public function contents() {
        $entries = [
            ['title' => 'Entry 1', 'author' => 'Bobbert Bob', 'created' => 'October 1, 2018 at 3:37 PM', 'excerpt' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic...'],
            ['title' => 'Entry 2', 'author' => 'Bobby Bob', 'created' => 'October 1, 2018 at 3:37 PM', 'excerpt' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic...'],
            ['title' => 'Entry 3', 'author' => 'Bonnie Bobbington', 'created' => 'October 1, 2018 at 3:37 PM', 'excerpt' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic...'],
            ['title' => 'Entry 4', 'author' => 'Boris Bobford', 'created' => 'October 1, 2018 at 3:37 PM', 'excerpt' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic...'],
            ['title' => 'Entry 5', 'author' => 'Boris Bobford', 'created' => 'October 1, 2018 at 3:37 PM', 'excerpt' => 'Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic...']
        ];

        return view('journal.contents', compact('entries', 'journal'));
    }

    public function read() {
        $journal = [
            'title' => 'An Interesting Title',
            'body'  => '<p>Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic.</p><p>Gumbo beet greens corn soko endive gumbo gourd. Parsley shallot courgette tatsoi pea sprouts fava bean collard greens dandelion okra wakame tomato. Dandelion cucumber earthnut pea peanut soko zucchini.</p><p>Turnip greens yarrow ricebean rutabaga endive cauliflower sea lettuce kohlrabi amaranth water spinach avocado daikon napa cabbage asparagus winter purslane kale. Celery potato scallion desert raisin horseradish spinach carrot soko. Lotus root water spinach fennel kombu maize bamboo shoot green bean swiss chard seakale pumpkin onion chickpea gram corn pea. Brussels sprout coriander water chestnut gourd swiss chard wakame kohlrabi beetroot carrot watercress. Corn amaranth salsify bunya nuts nori azuki bean chickweed potato bell pepper artichoke.</p><p>Nori grape silver beet broccoli kombu beet greens fava bean potato quandong celery. Bunya nuts black-eyed pea prairie turnip leek lentil turnip greens parsnip. Sea lettuce lettuce water chestnut eggplant winter purslane fennel azuki bean earthnut pea sierra leone bologi leek soko chicory celtuce parsley jícama salsify.</p><p>Celery quandong swiss chard chicory earthnut pea potato. Salsify taro catsear garlic gram celery bitterleaf wattle seed collard greens nori. Grape wattle seed kombu beetroot horseradish carrot squash brussels sprout chard.</p><p>Pea horseradish azuki bean lettuce avocado asparagus okra. Kohlrabi radish okra azuki bean corn fava bean mustard tigernut jícama green bean celtuce collard greens avocado quandong fennel gumbo black-eyed pea. Grape silver beet watercress potato tigernut corn groundnut. Chickweed okra pea winter purslane coriander yarrow sweet pepper radish garlic brussels sprout groundnut summer purslane earthnut pea tomato spring onion azuki bean gourd. Gumbo kakadu plum komatsuna black-eyed pea green bean zucchini gourd winter purslane silver beet rock melon radish asparagus spinach.</p><p>Beetroot water spinach okra water chestnut ricebean pea catsear courgette summer purslane. Water spinach arugula pea tatsoi aubergine spring onion bush tomato kale radicchio turnip chicory salsify pea sprouts fava bean. Dandelion zucchini burdock yarrow chickpea dandelion sorrel courgette turnip greens tigernut soybean radish artichoke wattle seed endive groundnut broccoli arugula.</p><p>Soko radicchio bunya nuts gram dulse silver beet parsnip napa cabbage lotus root sea lettuce brussels sprout cabbage. Catsear cauliflower garbanzo yarrow salsify chicory garlic bell pepper napa cabbage lettuce tomato kale arugula melon sierra leone bologi rutabaga tigernut. Sea lettuce gumbo grape kale kombu cauliflower salsify kohlrabi okra sea lettuce broccoli celery lotus root carrot winter purslane turnip greens garlic. Jícama garlic courgette coriander radicchio plantain scallion cauliflower fava bean desert raisin spring onion chicory bunya nuts. Sea lettuce water spinach gram fava bean leek dandelion silver beet eggplant bush tomato.</p>'
        ];
        return view('journal.read', compact('journal'));
    }

    public function write() {
        return view('journal.edit_entry', ['journal' => $this->journal1]);
    }

    public function create() {
        return view('journal.create');
    }

    public function invite() {
        return view('journal.invite', ['journal' => $this->journal1]);
    }
}
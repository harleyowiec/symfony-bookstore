<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class BooksDeleteCest
{
    const URL = '/books';
    const BOOK_ID = 88;


    public function _before(AcceptanceTester $I)
    {
        $I->haveInDatabase('book', [
            'id' => self::BOOK_ID,
            'name' => 'Testing book',
            'price' => 99.99,
            'number_of_pages' => 120,
            'year' => 2018,
            'created' => '2020-04-08 19:01:05'
        ]);
    }

    public function tryToDeleteBook(AcceptanceTester $I)
    {
        $I->amOnPage(self::URL);

        $I->see('Testing book');
        $I->click('//a[@href="/books/delete/'.self::BOOK_ID.'"]');

        $I->see('All books');
        $I->dontSee('Testing book');
    }
}

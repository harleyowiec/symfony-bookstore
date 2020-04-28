<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class BooksDeleteCest
{
    private const URL = '/books';
    private const BOOK_ID = 88;


    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I): void
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

    /**
     * @param AcceptanceTester $I
     */
    public function tryToDeleteBook(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('Testing book');
        $I->click('//a[@href="/books/'.self::BOOK_ID.'/delete"]');

        $I->see('All book');
        $I->dontSee('Testing book');
    }
}

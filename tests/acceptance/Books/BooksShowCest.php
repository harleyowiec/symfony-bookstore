<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class BooksShowCest
{
    private const BOOK_ID = 88;
    private const URL = '/books/'. self::BOOK_ID;

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
    public function tryToShowBook(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('Name: Testing book');
        $I->see(99.99);
    }
}

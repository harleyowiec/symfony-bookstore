<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class BooksUpdateCest
{
    const URL = '/books/edit/'. self::BOOK_ID;
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

    public function tryUpdateBook(AcceptanceTester $I)
    {
        $I->amOnPage(self::URL);

        $I->see('Edit book:');
        $I->seeInField(['name' => 'book[name]'],'Testing book');
        $I->fillField(['name' => 'book[name]'],'Edited book');
        $I->click('Save');
        $I->see('All books');
        $I->see('Edited book');
    }

    public function tryUpdateBookWithoutName(AcceptanceTester $I)
    {
        $I->amOnPage(self::URL);

        $I->see('Edit book:');
        $I->seeInField(['name' => 'book[name]'],'Testing book');
        $I->fillField(['name' => 'book[name]'],'');
        $I->click('Save');
        $I->dontSee('All books');
        $I->see('Edit book:');
    }
}

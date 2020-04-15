<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class BooksIndexCest
{
    const URL = '/books/';

    public function _before(AcceptanceTester $I)
    {
        $I->haveInDatabase('book', [
            'id' => 88,
            'name' => 'Testing book',
            'price' => 99.99,
            'number_of_pages' => 120,
            'year' => 2018,
            'created' => '2020-04-08 19:01:05'
        ]);
    }

    public function tryToDisplayAllBooks(AcceptanceTester $I)
    {
        $I->amOnPage(self::URL);

        $I->see('All books');
        $I->seeElement('.book-row');
        $I->see('Testing book');
    }

    public function tryToDisplayEditView(AcceptanceTester $I)
    {
        $I->amOnPage(self::URL);

        $I->click('//a[@href="/books/edit/88"]');
        $I->see('Edit book:');
        $I->seeInField(['name' => 'book[name]'],'Testing book');
    }
}

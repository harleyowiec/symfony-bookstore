<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class BooksStoreCest
{
    const URL = '/books/create';
    const BOOK_ID = 88;


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

    public function tryToCreateBook(AcceptanceTester $I)
    {
        $I->amOnPage(self::URL);

        $I->see('Add new book:');
        $I->fillField(['name' => 'book[name]'],'Fresh added book');
        $I->fillField(['name' => 'book[price]'],42.21);
        $I->fillField(['name' => 'book[number_of_pages]'],66);
        $I->fillField(['name' => 'book[year]'],2000);
        $I->click('Save');

        $I->see('All books');
        $I->see('Fresh added book');
    }

    public function tryCreateBookWithoutName(AcceptanceTester $I)
    {
        $I->amOnPage(self::URL);

        $I->see('Add new book:');
        $I->fillField(['name' => 'book[name]'],'');
        $I->click('Save');
        $I->dontSee('All books');
        $I->see('Add new book:');
    }

    public function _after(AcceptanceTester $I)
    {
        $I->deleteFromDatabase('book', [
            'id' => self::BOOK_ID
        ]);
    }
}

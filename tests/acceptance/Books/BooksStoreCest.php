<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class BooksStoreCest
{
    private const URL = '/books/create';
    private const BOOK_ID = 88;
    private const AUTHOR_ID = 88;

    public function _before(AcceptanceTester $I): void
    {
        $I->haveInDatabase('author', [
            'id' => self::AUTHOR_ID,
            'name' => 'Testing author',
            'surname' => 'Test surname',
            'birth_date' => '1992-01-01',
            'nickname' => 'lalal',
            'created' => '2020-04-08 19:01:05'
        ]);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryToCreateBook(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('Add new book:');
        $I->fillField(['name' => 'book[name]'],'Fresh added book');
        $I->fillField(['name' => 'book[price]'],42.21);
        $I->fillField(['name' => 'book[number_of_pages]'],66);
        $I->fillField(['name' => 'book[year]'],2000);
        $I->selectOption('#book_author', self::AUTHOR_ID);
        $I->click('Save');

        $I->see('All book');
        $I->see('Fresh added book');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryCreateBookWithoutName(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('Add new book:');
        $I->fillField(['name' => 'book[name]'],'');
        $I->click('Save');
        $I->dontSee('All book');
        $I->see('Add new book:');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function _after(AcceptanceTester $I): void
    {
        $I->deleteFromDatabase('book', [
            'name' =>'Fresh added book'
        ]);
    }
}

<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class BooksUpdateCest
{
    private const URL = '/books/'.self::BOOK_ID.'/edit';
    private const BOOK_ID = 88;
    private const AUTHOR_ID = 88;

    /**
     * @param AcceptanceTester $I
     */
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

        $I->haveInDatabase('book', [
            'id' => self::BOOK_ID,
            'name' => 'Testing book',
            'price' => 99.99,
            'number_of_pages' => 120,
            'year' => 2018,
            'author_id' => self::AUTHOR_ID,
            'created' => '2020-04-08 19:01:05'
        ]);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryUpdateBook(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('Edit book:');
        $I->seeInField(['name' => 'book[name]'],'Testing book');
        $I->fillField(['name' => 'book[name]'],'Edited book');
        $I->click('Save');
        $I->see('All book');
        $I->see('Edited book');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryUpdateBookWithoutName(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('Edit book:');
        $I->seeInField(['name' => 'book[name]'],'Testing book');
        $I->fillField(['name' => 'book[name]'],'');
        $I->click('Save');
        $I->dontSee('All book');
        $I->see('Edit book:');
        $I->seeInField(['name' => 'book[name]'],'');
    }
}

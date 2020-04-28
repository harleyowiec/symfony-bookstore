<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class BooksIndexCest
{
    private const URL = '/books/';
    private const FIRST_BOOK_ID = 88;
    private const SECOND_BOOK_ID = 89;
    private const FIRST_AUTHOR_ID = 88;
    private const SECOND_AUTHOR_ID = 89;

    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I): void
    {
        $I->haveInDatabase('author', [
            'id' => self::FIRST_AUTHOR_ID,
            'name' => 'Testing author',
            'surname' => 'Test surname',
            'birth_date' => '1992-01-01',
            'nickname' => 'lalal',
            'created' => '2020-04-08 19:01:05'
        ]);

        $I->haveInDatabase('author', [
            'id' => self::SECOND_AUTHOR_ID,
            'name' => 'Second author',
            'surname' => 'Second surname',
            'birth_date' => '1992-01-01',
            'nickname' => 'second',
            'created' => '2020-04-08 19:01:05'
        ]);

        $I->haveInDatabase('book', [
            'id' => self::FIRST_BOOK_ID,
            'name' => 'Testing book',
            'price' => 99.99,
            'number_of_pages' => 120,
            'year' => 2018,
            'author_id' => self::FIRST_AUTHOR_ID,
            'created' => '2020-04-08 19:01:05'
        ]);

        $I->haveInDatabase('book', [
            'id' => self::SECOND_BOOK_ID,
            'name' => 'Second book',
            'price' => 59.99,
            'number_of_pages' => 60,
            'year' => 2018,
            'author_id' => self::SECOND_AUTHOR_ID,
            'created' => '2020-04-08 19:01:05'
        ]);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryToDisplayAllBooks(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('All book');
        $I->seeElement('.book-row');
        $I->see('Testing book');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryToDisplayEditView(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->click('//a[@href="/books/'.self::FIRST_BOOK_ID.'/edit"]');
        $I->see('Edit book:');
        $I->seeInField(['name' => 'book[name]'],'Testing book');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryToDisplayShowView(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->click('//a[@href="/books/'.self::FIRST_BOOK_ID.'"]');
        $I->see('Name: Testing book');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryToFilterBooksByAuthor(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->selectOption('#filter_by_author_author', self::FIRST_AUTHOR_ID);
        $I->click('Search');
        $I->see('Testing book');
        $I->dontSee('Second book');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryToFilterBooksByName(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->fillField('#filter_by_author_name', 'Second');
        $I->click('Search');

        $I->see('Second book');
        $I->dontSee('Testing book');
    }
}

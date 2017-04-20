<?php

use CodeIgniter\View\Parser;

class ParserFilterTest extends \CIUnitTestCase
{
	protected $loader;
	protected $viewsDir;
	protected $config;

	public function setUp()
	{
		$this->loader   = new \CodeIgniter\Autoloader\FileLocator(new \Config\Autoload());
		$this->viewsDir = __DIR__.'/Views';
		$this->config   = new Config\View();
	}

	//--------------------------------------------------------------------

	public function testAbs()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => -5,
			'value2' => 5
		];

		$template = '{ value1|abs }{ value2|abs }';

		$parser->setData($data);
		$this->assertEquals('55', $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testCapitalize()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => 'wonder',
			'value2' => 'TWInS'
		];

		$template = '{ value1|capitalize } { value2|capitalize }';

		$parser->setData($data);
		$this->assertEquals('Wonder Twins', $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testDate()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$today = date('Y-m-d');

		$data = [
			'value1' => time(),
			'value2' => date('Y-m-d H:i:s'),
		];

		$template = '{ value1|date(Y-m-d) } { value2|date(Y-m-d) }';

		$parser->setData($data);
		$this->assertEquals("{$today} {$today}", $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testDateModify()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$today = date('Y-m-d');
		$tommorrow = date('Y-m-d', strtotime('+1 day'));

		$data = [
			'value1' => time(),
			'value2' => date('Y-m-d H:i:s'),
		];

		$template = '{ value1|date_modify(+1 day)|date(Y-m-d) } { value2|date_modify(+1 day)|date(Y-m-d) }';

		$parser->setData($data);
		$this->assertEquals("{$tommorrow} {$tommorrow}", $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testDefault()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => null,
			'value2' => 0,
			'value3' => 'test',
		];

		$template = '{ value1|default(foo) } { value2|default(bar) } { value3|default(baz) }';

		$parser->setData($data);
		$this->assertEquals("foo bar test", $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testEsc()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$value1 = esc('<script>', 'html');
		$value2 = esc('<script>', 'js');

		$data = [
			'value1' => '<script>'
		];

		$template = '{ value1|esc(html) } { value1|esc(js) }';

		$parser->setData($data);
		$this->assertEquals("{$value1} {$value2}", $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testExcerpt()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => 'The quick red fox jumped over the lazy brown dog'
		];

		$template = '{ value1|excerpt(jumped, 10) }';

		$parser->setData($data);
		$this->assertEquals("... red fox jumped over ...", $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testHighlight()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => 'The quick red fox jumped over the lazy brown dog'
		];

		$template = '{ value1|highlight(jumped over) }';

		$parser->setData($data);
		$this->assertEquals("The quick red fox <mark>jumped over</mark> the lazy brown dog", $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testLimitChars()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => 'The quick red fox jumped over the lazy brown dog'
		];

		$template = '{ value1|limit_chars(10) }';

		$parser->setData($data);
		$this->assertEquals("The quick&#8230;", $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testLimitWords()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => 'The quick red fox jumped over the lazy brown dog'
		];

		$template = '{ value1|limit_words(4) }';

		$parser->setData($data);
		$this->assertEquals("The quick red fox&#8230;", $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testLower()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => 'SOMETHING'
		];

		$template = '{ value1|lower }';

		$parser->setData($data);
		$this->assertEquals("something", $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testNL2BR()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => "first\nsecond"
		];

		$template = '{ value1|nl2br }';

		$parser->setData($data);
		$this->assertEquals("first<br />\nsecond", $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testNumberFormat()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => 1098.3455433553,
		];

		$template = '{ value1|number_format(2) }';

		$parser->setData($data);
		$this->assertEquals('1,098.35', $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testRound()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => 5.55,
		];

		$template = '{ value1|round(1) } { value1|round(1, common) } { value1|round(ceil) } { value1|round(floor) }';

		$parser->setData($data);
		$this->assertEquals('5.6 5.6 6 5', $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testStripTags()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => '<p><b>Middle</b></p>',
		];

		$template = '{ value1|strip_tags } { value1|strip_tags(<b>) }';

		$parser->setData($data);
		$this->assertEquals('Middle <b>Middle</b>', $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testTitle()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => 'THOUGH SHE BE LITTLE',
		];

		$template = '{ value1|title }';

		$parser->setData($data);
		$this->assertEquals('Though She Be Little', $parser->renderString($template));
	}

	//--------------------------------------------------------------------

	public function testUpper()
	{
		$parser = new Parser($this->config, $this->viewsDir, $this->loader);

		$data = [
			'value1' => 'Though She Be Little',
		];

		$template = '{ value1|upper }';

		$parser->setData($data);
		$this->assertEquals('THOUGH SHE BE LITTLE', $parser->renderString($template));
	}

	//--------------------------------------------------------------------
}
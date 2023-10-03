<?php

App::uses('AppController', 'Controller');

/**
 * Start page
 */
class StartController extends AppController
{
	public $name = 'Start';

	public $uses = ['Slide', 'Industry', 'Partner', 'Portfolio', 'Quote', 'Subsection', 'SectionHeading', 'Service', 'Certificate', 'Article'];

	/**
	 * @return void
	 */
	public function index(): void {
		$slides = $this->Slide->findActive($this->lang);
		$industries = $this->Industry->findAllActive();
		$partners = $this->Partner->findAllActive();
		$services = $this->Service->findAllActive();
		$articles = $this->Article->findLatest($this->lang);
		$portfolio = $this->Portfolio->findLatest($this->lang, false, $this->mobile);
		$quotes = $this->Quote->getRandomQuotes($this->lang);
		$subsections = $this->Subsection->findList(['tag', 'text'], false, ['lang' => $this->lang]);
		$section_headings = $this->SectionHeading->findList(['tag', 'text'], false, ['lang' => $this->lang]);
		$certificates = $this->Certificate->findAllActive();
		// don't leave gaps
		if (!$this->mobile) {
			$carry1 = 4 - (count($portfolio) % 4);
			if ($carry1) {
				$portfolio = array_merge($portfolio, array_slice($portfolio, 0, $carry1));
			}
		}

		// don't leave gaps
		$carry2 = 8 - (count($partners) % 8);
		if ($carry2) {
			$partners = array_merge($partners, array_slice($partners, 0, $carry2));
		}

		$is_frontpage = true;

		$urls = Sitemap::getLanguageUrls('start');
		
		$this->set(compact('slides', 'industries', 'partners', 'portfolio', 'articles', 'quotes', 'subsections', 'section_headings', 'services', 'certificates', 'is_frontpage', 'urls'));

		if ($this->mobile) {
			$this->render('mobile/index', 'mobile');
		}
	}
}

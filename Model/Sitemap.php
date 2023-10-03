<?php

class Sitemap extends AppModel
{

    public static function getLanguageUrls(string $controller, ?string $language = null, ?string $slug = null, ?string $model = null) {

        $config_langs = array_keys(Configure::read('Languages.all'));

		if ($language !== null && $slug !== null && $model !== null) {	
			$fields = array_map(fn($lang) => 'strid_' . $lang, $config_langs);
			$fields[] = 'translated';

			$conditions['strid_'. $language] = $slug;

			if ($model !== 'Section') {
				$conditions['enabled'] = 1;
			} 
            $Model = ClassRegistry::init($model);
			$data = $Model->find('all', [
				'conditions' => $conditions,
				'fields' => $fields
			]);

			foreach ($data as $v) {
				$langs = array_intersect($config_langs, $v[$model]['translated']);
			
				foreach ($langs as $lang) {				
					$urls[$lang] = Router::url(['lang' => $lang, 'controller' => $controller, 'action' => 'view', $v[$model]['strid_' . $lang]], true);
				}			
			}
		} else {
			foreach ($config_langs as $lang) {
				$urls[$lang] = rtrim(Router::url(['lang' => $lang, 'controller' => $controller, 'action' => 'index'], true), '/');								
			}
		}
		return $urls;
}
}

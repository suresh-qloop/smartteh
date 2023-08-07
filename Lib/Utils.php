<?php

/**
 * Static utility class for common things that might be used anywhere in
 * our applications
 */
class Utils
{
	/**
	 * Get file extension
	 *
	 * @param string $filename Filename
	 *
	 * @return string
	 */
	static function getExtension($filename) {
		if (strpos($filename, '.') === false) {
			return '';
		}

		$chunks = explode('.', strtolower($filename));

		return end($chunks);
	}

	/**
	 * Generate random string
	 *
	 * @param int $length Length
	 * @param string $charset Chars to use in generation
	 *
	 * @return string
	 */
	static function randomString($length = 20, $charset = null) {
		if (empty($charset)) {
			$charset = '0123456789abcdefghijklmnopqrstuvwxyz';
		}
		$l = strlen($charset) - 1;
		$r = '';
		for ($n = 0; $n < $length; $n++) {
			$r .= $charset[mt_rand(0, $l)];
		}

		return $r;
	}

	/**
	 * Nicely truncate a sentence
	 *
	 * @param string $string Input text
	 * @param int $limit Output string's minimal length
	 * @param mixed $break Array of break characters (or single string character)
	 * @param string $pad If output string is shorter than input, pad string
	 *
	 * @return string
	 */
	static function truncate($string, $limit, $break = ['.', ',', '!', '?', ';'], $pad = '…') {
		if (strlen($string) <= $limit) {
			return $string;
		}

		if (!is_array($break)) {
			$break = [$break];
		}

		$breakpoint = false;
		$actual_break = "";

		$pos = mb_strlen($string, 'utf-8');

		foreach ($break as $v) {
			$breakpoint = strpos($string, $v, $limit);

			if ($breakpoint !== false && $breakpoint < $pos) {
				$pos = $breakpoint;
				$actual_break = $v;
			}
		}

		if (!empty($actual_break)) {
			if ($pos < strlen($string) - 1) {
				$string = substr($string, 0, $pos);

				if (!empty($pad)) {
					$string .= $pad;
				} else {
					$string .= $actual_break;
				}
			}
		}

		return $string;
	}

	/**
	 * Remove all elements with specified value
	 *
	 * @param array $input Input array
	 * @param mixed $value Value to search for
	 * @param boolean $first_only If true, remove only first found element
	 *
	 * @return array
	 */
	static function removeValues($input, $value, $first_only = false) {
		foreach ($input as $k => $v) {
			if ($v == $value) {
				unset($input[$k]);

				if ($first_only) {
					return $input;
				}
			}
		}

		return $input;
	}

	/**
	 * Calculate Age
	 *
	 * @param string $birthdate
	 *
	 * @return int Age
	 */
	static function calculateAge($birthdate) {
		$ts = strtotime($birthdate);

		$year_diff = date('Y') - date('Y', $ts);
		$month_diff = date('m') - date('m', $ts);
		$day_diff = date('d') - date('d', $ts);

		if ($month_diff < 0) {
			$year_diff--;
		} elseif ($month_diff == 0 && $day_diff < 0) {
			$year_diff--;
		}

		return $year_diff;
	}

	/**
	 * Get client IP
	 *
	 * Šis ir kopija no RequestHandler:getClientIP lai būtu pieejams visur
	 * Piezīme - šis izmanto HTTP_X_FORWARDED_FOR, ja tāds ir, kas teorētiski ir nedroši,
	 * jo X_FORWARDED_FOR headeri var iestatīt ari klients.
	 */
	static function getClientIP() {
		if (env('HTTP_X_FORWARDED_FOR') != null) {
			$ipaddr = env('HTTP_X_FORWARDED_FOR');
		} elseif (env('HTTP_CLIENTADDRESS') != null) {
			$ipaddr = env('HTTP_CLIENTADDRESS');
		} elseif (env('HTTP_CLIENT_IP') != null) {
			$ipaddr = env('HTTP_CLIENT_IP');
		} else {
			$ipaddr = env('REMOTE_ADDR');
		}

		$ipaddr = preg_replace('/(?:,.*)/', '', $ipaddr);

		return trim($ipaddr);
	}

	/**
	 * Calculates how many days are between two dates
	 *
	 * @param string $to End date of the time period, strtotime format
	 * @param string $from Start date if the time period, strtotime format. Today is the default.
	 *
	 * @return int Difference in days
	 */
	static function dayRange($to, $from = null) {
		$end = strtotime($to);

		if ($from === null) {
			$start = time();
		} else {
			$start = strtotime($from);
		}

		return floor(($end - $start) / (60 * 60 * 24));
	}

	/**
	 * F-ja atgriež e-pastus, kas savienoti teksta virknē (atdalīti ar komatu), pie reizes izņemot
	 * atstarpes un izmetot tos ierakstus, kas nav e-pasti
	 *
	 * @param string $str Piem.:  name@example.com, name2@example.com
	 *
	 * @return array Piem.: array(0 => name@example.com, 1 => name2@example.com)
	 */
	static function validEmails($str) {
		$emails = explode(',', $str);

		foreach ($emails as $k => $v) {
			$v = trim($v);

			if (filter_var($v, FILTER_VALIDATE_EMAIL)) {
				$emails[$k] = $v;
			} else {
				unset($emails[$k]);
			}
		}

		return $emails;
	}

	/**
	 * Apvienojam divu masīvu vērtības vienā masīvā. Abiem masīviem jāsatur vienāds elementu skaits.
	 * Indeksi tiek atstāti no $arr1
	 *
	 * Piemērs:
	 *
	 * Array1: array(
	 *     'a' => 'Name1',
	 *     'b' => 'Name2'
	 * );
	 *
	 * Array2: array(
	 *     'c' => 'Surname1',
	 *     'd' => 'Surname2'
	 * );
	 *
	 * Result: array(
	 *     'a' => 'Name1 Surname1',
	 *     'b' => 'Name2 Surname2'
	 * );
	 *
	 * @param array $arr1
	 * @param array $arr2
	 * @param string $separator Vērtību atdalītājs
	 *
	 * @return mixed
	 */
	static function joinValues($arr1, $arr2, $separator = ' ') {
		if (count($arr1) != count($arr2)) {
			return false;
		}

		$arr2 = array_values($arr2);
		$n = 0;

		foreach ($arr1 as $k => $v) {
			$arr1[$k] = $v.$separator.$arr2[$n++];
		}

		return $arr1;
	}

	/**
	 * Atgriežam jaunu faila nosaukumu balstoties uz esošo, bet tā, lai saglabājot failu, netiktu
	 * pārrakstīts kāds esošs. Lai būtu nebūtu problēmas ar nosaukumu encodingu, aizvietojam latviešu
	 * un krievu simbolus ar ascii ekvivalentiem. Ja fails jau eksistē, faila beigās (bet pirms
	 * paplašinājuma) pieliekam kārtas numuru. Piemēram: direktorijā eksistē tikai viens fails:
	 * debug.log. Padodod f-jai šo ceļu un nosaukumu "debug.log", tiks atgriezts "debug.1.log".
	 * Saglabājot failu un atkārtoti izsaucot f-ju, tiks atgriezts "debug.2.log" utt
	 *
	 * @param string $filename Faila nosaukums
	 * @param string $path Direktorija, kurā glabāsies fails
	 * @param int $limit Ja faila nosaukums netiks atrasts $limit iterācijās, tiks atgriezts false
	 *
	 * @return mixed string|boolean
	 */
	static function safeFilename($filename, $path, $limit = 1000) {
		$ext = self::getExtension($filename);
		$name = ($ext ? mb_substr($filename, 0, -(strlen($ext) + 1), 'UTF-8') : $filename);

		if ($ext) {
			$ext = '.'.$ext;
		}

		$filename = self::slugify($name);
		$current_filename = $filename.$ext;

		$n = 1;

		while (true) {
			if (!file_exists($path.$current_filename)) {
				return $current_filename;
			}

			if ($n > $limit) {
				return false;
			}

			$current_filename = $filename.'.'.($n++).$ext;
		}

		return $filename.$ext;
	}

	/**
	 * Calculate the distance from a point A to a point B, using latitudes and longitudes.
	 *
	 * Distance can be returned in miles, kilometers, or nautical miles
	 *
	 * @param float $lat1 Latitude of starting point
	 * @param float $lon1 Longitude of starting point
	 * @param float $lat2 Latitude of ending point
	 * @param float $lon2 Longitude of ending point
	 * @param string $unit (m|k|n) Miles, kilometers, nautical miles
	 *
	 * @return float
	 */
	static function distance($lat1, $lon1, $lat2, $lon2, $unit) {
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "k") {
			return ($miles * 1.609344);
		} else {
			if ($unit == "n") {
				return ($miles * 0.8684);
			} else {
				return $miles;
			}
		}
	}

	/**
	 * Try to create specified path
	 *
	 * @param string $output_path
	 * @param mixed $chmod Each folder's permissions
	 *
	 * @return boolean
	 */
	static function createPath($output_path, $chmod = 0777) {
		$arr_output_path = explode(DIRECTORY_SEPARATOR, $output_path);

		unset($arr_output_path[count($arr_output_path) - 1]);

		$dir_path = implode($arr_output_path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

		if (!file_exists($dir_path)) {
			if (!mkdir($dir_path, $chmod, true)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Modifies a string to remove all non ASCII characters and spaces
	 */
	static function slugify($string) {
		$text = mb_strtolower($string, 'utf-8');

		$text = str_replace(
			['ā', 'ē', 'ū', 'ī', 'š', 'ģ', 'ķ', 'ļ', 'ž', 'č', 'ņ', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'],
			['a', 'e', 'u', 'i', 's', 'g', 'k', 'l', 'z', 'c', 'n', 'a', 'b', 'v', 'g', 'd', 'e', 'jo', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shh', '#', 'y', 'j', 'e', 'ju', 'ja'],
			$text
		);

		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);

		// trim
		$text = trim($text, '-');

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		if (empty($text)) {
			return $string;
		}

		return $text;
	}

	/**
	 * List all files which should be searched for strings
	 *
	 * @return array
	 */
	public static function listWorkingFiles() {
		$files = [
			APP.'Controller',
			APP.'Model',
			APP.'View'
		];

		$all_files = [];

		foreach ($files as $file) {
			if (is_dir($file)) {
				self::findAllFiles($file, $all_files);
			} else {
				if (in_array(end(explode('.', $file)), ['php', 'ctp'])) {
					$all_files[] = $file;
				}
			}
		}

		return $all_files;
	}

	/**
	 * Recursively find all php and ctp files
	 *
	 * @param string $dir Parent directory path
	 * @param $all_files Variable where found files are stored
	 *
	 * @return array
	 */
	public static function findAllFiles($dir, &$all_files) {
		if (!is_dir($dir)) {
			return [];
		}

		$files = scandir($dir);

		foreach ($files as $file) {
			if ($file == '.' || $file == '..') {
				continue;
			}

			if (is_dir($dir.DS.$file)) {
				self::findAllFiles($dir.DS.$file, $all_files);
			} else {
				$tmp = explode('.', $file);
				if (in_array(end($tmp), ['php', 'ctp'])) {
					$all_files[] = $dir.DS.$file;
				}
			}
		}
	}

	/**
	 * Extract e-mails from text
	 *
	 * E-mails can be separated by any whitespace, comma or semicolon
	 *
	 * @param mixed $text Text to extract e-mails from
	 * @param boolean $unique_only If true, return only unique emails
	 *
	 * @return mixed
	 */
	public static function extractEmails($text, $unique_only = false) {
		if (!is_string($text)) {
			return $text;
		}

		$matches = preg_split('/[\s,;]+/', $text);

		if ($unique_only) {
			return array_unique($matches);
		}

		return $matches;
	}

	/**
	 * Recursively remove node(s) (files/directories)
	 *
	 * @param mixed $nodes (string|string[]) Directories or files to remove
	 *
	 * @return void
	 */
	public static function deleteNode($nodes) {
		foreach ((array)$nodes as $node) {
			if (is_file($node)) {
				$r = unlink($node);
				continue;
			}

			if (!is_dir($node)) {
				continue;
			}

			$objects = scandir($node);

			foreach ($objects as $object) {
				if ($object === '.' || $object === '..') {
					continue;
				}

				$filepath = $node.DIRECTORY_SEPARATOR.$object;

				if (is_dir($filepath)) {
					self::deleteNode($filepath);
				} else {
					unlink($filepath);
				}
			}

			rmdir($node);
		}
	}

	/**
	 * Extract all tags from string
	 *
	 * @param string $str Input string containing tags separated by $delimiter
	 * @param string $delimiter
	 *
	 * @return string[]
	 */
	public static function extractTags($str, $delimiter = ',') {
		$tags = explode($delimiter, $str);

		return array_map('trim', $tags);
	}

	/**
	 * Linkify twitter usernames
	 *
	 * @param string $text
	 *
	 * @return string
	 */
	public static function linkifyTwitterUsernames($text) {
		$pattern = '/@([a-zA-Z0-9_]+)/';
		$replace = '<a href="https://twitter.com/$1">@$1</a>';

		return preg_replace($pattern, $replace, $text);
	}

	/**
	 * Check if $value matches any other value in list by regex
	 *
	 * @param string $value Value to check
	 * @param string[] $list Values to check against (can be regexps)
	 *
	 * @return boolean
	 */
	public static function matchesByRegexInList($value, $list) {
		foreach ($list as $v) {
			if (preg_match('/'.trim($v).'/', $value)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Linkify underlined plaintext
	 *
	 * Example of underlined text: I will become _link_. Hooray
	 *
	 * @param string $text
	 * @param string $url
	 *
	 * @return string
	 */
	public static function linkifyUnderlined($text, $url) {
		if (preg_match('/(_(.*)_)/', $text, $matches)) {
			$url = '<a href="'.$url.'">'.$matches[2].'</a>';
			$text = str_replace($matches[1], $url, $text);
		}

		return $text;
	}

	/**
	 * @return string
	 */
	public static function uuid4(): string {
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

			// 32 bits for "time_low"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff),

			// 16 bits for "time_mid"
			mt_rand(0, 0xffff),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand(0, 0x0fff) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand(0, 0x3fff) | 0x8000,

			// 48 bits for "node"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}
}

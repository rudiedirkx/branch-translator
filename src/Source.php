<?php

namespace rdx\branchtrans;

class Source extends Model {

	static public $_table = 'sources';

	static function groupSources(array $sources) : array {
		$grouped = [];
		foreach ($sources as $source) {
			$grouped[$source->parent_source_id ?? 0][] = $source;
		}
		return $grouped;
	}

	static function pathSources(array $sources, ?int $start = null) : array {
		$grouped = Source::groupSources($sources);

		if ($start) {
			$start = $sources[$start];
		}
		else {
			$start = $grouped[0][0];
		}

		$path = self::pathSourcesSingle($grouped, $start);
		if (count($branch = end($path)) > 1) {
			$nextPaths = array_map(function(Source $source) use ($grouped) {
				$path = self::pathSourcesSingle($grouped, $source);
				$path = array_slice($path, 1);
				// if (count(end($path)) > 1) {
				// 	$path = array_slice($path, 0, -1);
				// }
				$path = array_map(function(array $options) {
					return count($options) == 1 ? $options[0] : count($options);
				}, $path);
				return $path;
			}, $branch);

			$nextPaths = self::combinePaths(...$nextPaths);
			$path = array_merge($path, self::flip2d($nextPaths));
		}

		return $path;
	}

	static function pathSourcesSingle(array $grouped, self $start) : array {
		$current = $start;
		$path = [[$start]];
		while (isset($grouped[$current->id])) {
			$path[] = $grouped[$current->id];

			if (count($grouped[$current->id]) != 1) break;
			$current = $grouped[$current->id][0];
		}

		return $path;
	}

	static function combinePaths(array ...$paths) {
		$max = max(array_map('count', $paths));
		$combined = [];
		for ($i = 0; $i < $max; $i++) {
			foreach ($paths as $p => $x) {
				$combined[$p][$i] = $paths[$p][$i] ?? null;
			}
		}

		return $combined;
	}

	static function flip2d(array $input) {
		$output = [];
		foreach ($input as $a => $row) {
			foreach ($row as $b => $cell) {
				$output[$b][$a] = $cell;
			}
		}

		return $output;
	}

}

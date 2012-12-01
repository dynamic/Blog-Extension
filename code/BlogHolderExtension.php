<?php

class BlogHolderExtension extends DataExtension {

	// static for getTagsList
	static $popularities = array( 'not-popular', 'not-very-popular', 'somewhat-popular', 'popular', 'very-popular', 'ultra-popular' );
	
	// Featured News
	public function getFeaturedNews() {
		return BlogEntry::get()->filter(array('Featured' => 1))->sort('Date DESC')->limit(3);
	}
	
	
	
	public function getTagsList() {
		
		$allTags = array();
		$max = 0;
		$limit = 0;
		$sortby = 'popularity';
		$container = BlogTree::current();
		
		$entries = BlogEntry::get();
		//$entries = $this->owner->Entries();
		
		if($entries) {
			foreach($entries as $entry) {
				$theseTags = preg_split(" *, *", mb_strtolower(trim($entry->Tags)));
				foreach($theseTags as $tag) {
					if($tag != "") {
						$allTags[$tag] = isset($allTags[$tag]) ? $allTags[$tag] + 1 : 1; //getting the count into key => value map
						$max = ($allTags[$tag] > $max) ? $allTags[$tag] : $max;
					}
				}
			}
		
			if($allTags) {		
				//TODO: move some or all of the sorts to the database for more efficiency
				if($limit > 0) $allTags = array_slice($allTags, 0, $limit, true);
				
				if($sortby == "alphabet"){
					$this->natksort($allTags);
				} else{
					uasort($allTags, array($this, "column_sort_by_popularity")); // sort by frequency
				}
				
				$sizes = array();	
				foreach ($allTags as $tag => $count) $sizes[$count] = true;
				
				$offset = 0; 
				
				$numsizes = count($sizes)-1; //Work out the number of different sizes
				$buckets = count(self::$popularities)-1;
				
				// If there are more frequencies than buckets, divide frequencies into buckets
				if ($numsizes > $buckets) {
					$numsizes = $buckets;
				}
				// Otherwise center use central buckets
				else {
					$offset   = round(($buckets-$numsizes)/2);
				}
				/**/
				
				foreach($allTags as $tag => $count) {
					$popularity = round($count / $max * $numsizes) + $offset; $popularity=min($buckets,$popularity);
					$class = self::$popularities[$popularity];
					
					$allTags[$tag] = array(
						"Tag" => $tag,
						"Count" => $count,
						"Class" => $class,
						"Link" => $container->Link('tag') . '/' . urlencode($tag)		
					);
				}
			}
			
			$output = new ArrayList();
			foreach($allTags as $tag => $fields) {
				$output->push(new ArrayData($fields));
			}
			
			return $output->sort('Count', 'DESC')->Limit(10)->sort('Tag');	
		}
	}
	
	private function column_sort_by_popularity($a, $b){
		if($a == $b) {
			$result  = 0;
		} 
		else {
			$result = $b - $a;
		}
		return $result;
	}

	private function natksort(&$aToBeSorted) {
		$aResult = array();
		$aKeys = array_keys($aToBeSorted);
		natcasesort($aKeys);
		foreach ($aKeys as $sKey) {
		    $aResult[$sKey] = $aToBeSorted[$sKey];
		}
		$aToBeSorted = $aResult;

		return true;
	}
	
	
	// News Archives
	public function getNewsArchive() {
		return GroupedList::create(BlogEntry::get()->sort('Date DESC'));
	}
	
	
	
}
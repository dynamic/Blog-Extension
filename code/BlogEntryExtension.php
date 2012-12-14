<?php
 
class BlogEntryExtension extends DataExtension {

	static $db = array(
		'Featured' => 'Boolean'
	);

	static $has_one = array(
		'Image' => 'Image',
		'Thumbnail' => 'Image'
	);
	
	public function updateCMSFields(FieldList $fields) {
		
		// Main Image
		$ImageField = new UploadField('Image', 'Main Image');
		$ImageField->getValidator()->allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
		$ImageField->setConfig('allowedMaxFileNumber', 1);
		$ImageField->setFolderName('Uploads/BlogEntries');
		$fields->addFieldToTab('Root.Images', $ImageField);
		
		// Thumbnail Image
		$ImageField = new UploadField('Thumbnail', 'Thumbnail Preview (square)');
		$ImageField->getValidator()->allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
		$ImageField->setConfig('allowedMaxFileNumber', 1);
		$ImageField->setFolderName('Uploads/BlogEntryThumbs');
		//$fields->addFieldToTab('Root.Images', $ImageField);
		
		// featured
		$fields->addFieldToTab('Root.Main', new CheckboxField('Featured', 'Featured Post (display link in Featured box in sidebar)'), 'Content');

	}
	
	public function getArticle() {
		
		if ($this->owner->ThumbnailID) {
			$extra = '<img src="' . $this->owner->Thumbnail()->setWidth(200)->URL . '" class="left">';
			$content = $this->owner->Content;
			
			$pos = strpos($content, '</p>') + 4;
			$content = substr($content, 0, $pos) . $extra . substr($content, $pos);
		} else {
			$content = $this->owner->Content;
		}
		
		return $content;
	}
	
	// News Archive Grouping
	public function getMonthCreated() {
        return date('F Y', strtotime($this->owner->Date));
    }
 
}
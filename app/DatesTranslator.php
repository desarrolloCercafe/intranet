<?php 

	namespace App;

	use Jenssegers\Date\Date;

	trait DatesTranslator{
		public function getMesTrasladoAttributa($date)
		{
			return new Date($date);
		}
	} 
?>
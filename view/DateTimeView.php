<?php

namespace view;

	class DateTimeView {

		public function getFormattedDateString() {
			$dateString = date('j');
			$ordialDate = new \NumberFormatter( 'en', \NumberFormatter::ORDINAL );
			$ordialDate = $ordialDate->format($dateString);

			$day = date('l');
			$month = date('F');
			$year = date('Y');

			$hour = date('H');
			$minute = date('i');
			$second = date('s');


			$timeString = "$day, the $ordialDate of $month $year, The time is $hour:$minute:$second.";
			
			return '<p>' . $timeString . '</p>';
		}
	}
?>
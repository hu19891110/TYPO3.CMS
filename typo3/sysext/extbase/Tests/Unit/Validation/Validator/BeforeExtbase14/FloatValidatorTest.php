<?php
namespace TYPO3\CMS\Extbase\Tests\Unit\Validation\Validator\BeforeExtbase14;

/***************************************************************
 *  Copyright notice
 *
 *  This class is a backport of the corresponding class of TYPO3 Flow.
 *  All credits go to the TYPO3 Flow team.
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the text file GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * Testcase for the float validator
 *
 * This testcase checks the expected behavior for Extbase < 1.4.0, to make sure
 * we do not break backwards compatibility.
 */
class FloatValidatorTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	/**
	 * Data provider with valid floating point numbers
	 *
	 * @return array Floats, both as float and string
	 */
	public function validFloatingPointNumbers() {
		return array(
			array(1029437.234726),
			array(-666.66),
			array('123.45'),
			array('+123.45'),
			array('-123.45'),
			array('123.45e3'),
			array(123450.0)
		);
	}

	/**
	 * Data provider with valid floating point numbers
	 *
	 * @return array Floats, both as float and string
	 */
	public function invalidFloatingPointNumbers() {
		return array(
			array(1029437),
			array(-666),
			array('1029437'),
			array('-666'),
			array('not a number')
		);
	}

	/**
	 * @test
	 * @dataProvider validFloatingPointNumbers
	 * @param mixed $number
	 */
	public function floatValidatorReturnsTrueForAValidFloat($number) {
		$floatValidator = $this->getMock('TYPO3\\CMS\\Extbase\\Validation\\Validator\\FloatValidator', array('addError'), array(), '', FALSE);
		$floatValidator->expects($this->never())->method('addError');
		$floatValidator->isValid($number);
	}

	/**
	 * @test
	 * @dataProvider invalidFloatingPointNumbers
	 * @param mixed $number
	 */
	public function floatValidatorReturnsFalseForAnInvalidFloat($number) {
		$floatValidator = $this->getMock('TYPO3\\CMS\\Extbase\\Validation\\Validator\\FloatValidator', array('addError', 'translateErrorMessage'), array(), '', FALSE);
		$floatValidator->expects($this->once())->method('addError');
		$floatValidator->isValid($number);
	}

	/**
	 * @test
	 */
	public function floatValidatorCreatesTheCorrectErrorForAnInvalidSubject() {
		$floatValidator = $this->getMock('TYPO3\\CMS\\Extbase\\Validation\\Validator\\FloatValidator', array('addError', 'translateErrorMessage'), array(), '', FALSE);
		// we only test for the error key, after the translation method is mocked.
		$floatValidator->expects($this->once())->method('addError')->with(NULL, 1221560288);
		$floatValidator->isValid(123456);
	}
}

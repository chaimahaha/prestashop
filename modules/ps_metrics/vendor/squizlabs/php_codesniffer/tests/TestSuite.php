<?php

/**
 * A PHP_CodeSniffer specific test suite for PHPUnit.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace ps_metrics_module_v4_0_6\PHP_CodeSniffer\Tests;

use ps_metrics_module_v4_0_6\PHPUnit\Framework\TestResult;
use ps_metrics_module_v4_0_6\PHPUnit\Framework\TestSuite as PHPUnit_TestSuite;
class TestSuite extends PHPUnit_TestSuite
{
    /**
     * Runs the tests and collects their result in a TestResult.
     *
     * @param \PHPUnit\Framework\TestResult $result A test result.
     *
     * @return \PHPUnit\Framework\TestResult
     */
    public function run(TestResult $result = null)
    {
        $result = parent::run($result);
        printPHPCodeSnifferTestOutput();
        return $result;
    }
    //end run()
}
//end class

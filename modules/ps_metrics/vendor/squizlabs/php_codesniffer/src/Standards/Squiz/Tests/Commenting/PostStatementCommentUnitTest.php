<?php

/**
 * Unit test class for the PostStatementComment sniff.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/PHPCSStandards/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
namespace ps_metrics_module_v4_0_6\PHP_CodeSniffer\Standards\Squiz\Tests\Commenting;

use ps_metrics_module_v4_0_6\PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;
/**
 * Unit test class for the PostStatementComment sniff.
 *
 * @covers \PHP_CodeSniffer\Standards\Squiz\Sniffs\Commenting\PostStatementCommentSniff
 */
final class PostStatementCommentUnitTest extends AbstractSniffUnitTest
{
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @param string $testFile The name of the file being tested.
     *
     * @return array<int, int>
     */
    public function getErrorList($testFile = '')
    {
        switch ($testFile) {
            case 'PostStatementCommentUnitTest.inc':
                return [6 => 1, 10 => 1, 18 => 1, 35 => 1, 53 => 1];
            case 'PostStatementCommentUnitTest.1.js':
                return [1 => 1, 4 => 1, 9 => 1];
            default:
                return [];
        }
        //end switch
    }
    //end getErrorList()
    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array<int, int>
     */
    public function getWarningList()
    {
        return [];
    }
    //end getWarningList()
}
//end class

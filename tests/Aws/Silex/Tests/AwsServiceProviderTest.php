<?php
/**
 * Copyright 2013 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Aws\Silex\Tests;

use Aws\Silex\AwsServiceProvider;
use Silex\Application;

/**
 * AwsServiceProvider test cases
 */
class AwsServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterAwsServiceProvider()
    {
        $app = new Application();
        $provider = new AwsServiceProvider();
        $app->register($provider, array(
            'aws.config' => array(
                'key'    => 'your-aws-access-key-id',
                'secret' => 'your-aws-secret-access-key',
            )
        ));
        $provider->boot($app);

        // Verify that the app and clients created by the SDK receive the provided credentials
        $this->assertEquals('your-aws-access-key-id', $app['aws.config']['key']);
        $this->assertEquals('your-aws-secret-access-key', $app['aws.config']['secret']);
        $this->assertEquals('your-aws-access-key-id', $app['aws']->get('s3')->getCredentials()->getAccessKeyId());
        $this->assertEquals('your-aws-secret-access-key', $app['aws']->get('s3')->getCredentials()->getSecretKey());
    }
}
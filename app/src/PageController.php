<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\Control\HTTPResponse;

    class PageController extends ContentController
    {
        /**
         * An array of actions that can be accessed via a request. Each array element should be an action name, and the
         * permissions or conditions required to allow the user to access it.
         *
         * <code>
         * [
         *     'action', // anyone can access this action
         *     'action' => true, // same as above
         *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
         *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
         * ];
         * </code>
         *
         * @var array
         */
        private static $allowed_actions = [];

        protected function init()
        {
            parent::init();
            // You can include any CSS or JS required by your project here.
            // See: https://docs.silverstripe.org/en/developer_guides/templates/requirements/
        }

        public function jsonResponse($json) : HTTPResponse
        {
            if (is_array($json)) {
                $json = json_encode($json);
            }
            $response = new HTTPResponse();
            $response->setBody($json);
            $response->addHeader('Content-type', 'application/json');
            return $response;
        }

//        public function getPayloadData($request = null)
//        {
//            $json = $this->getRequest()->getBody();
//            if ($json) {
//                return json_decode($json, true);
//            }
//            return null;
//        }

    }
}

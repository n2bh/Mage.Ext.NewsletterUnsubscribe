<?php

class SotaStudio_NewsletterUnsubscribe_UnsubscriberController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		if ( ($this->getRequest()->isPost() && $this->getRequest()->getPost('email'))
			 || ($this->getRequest()->isGet() && $this->getRequest()->getParam('email')) )
		{
            $session = Mage::getSingleton('core/session');
            $email   = (string) ( $this->getRequest()->getPost('email') )
				? $this->getRequest()->getPost('email')
				: $this->getRequest()->getParam('email');

            try {
                if (!Zend_Validate::is($email, 'EmailAddress')) {
                    Mage::throwException($this->__('Please enter a valid email address.'));
                }

                $status = Mage::getModel('newsletter/subscriber')->unsubscribeByEmail($email);
                $session->addSuccess($this->__('You have been unsubscribed.'));
            }
            catch (Mage_Core_Exception $e) {
                $session->addException($e, $this->__('There was a problem with the unsubscription: %s', $e->getMessage()));
            }
            catch (Exception $e) {
                $session->addException($e, $this->__('There was a problem with the unsubscription.'));
            }
        }
        $this->_redirectReferer();
    }
}
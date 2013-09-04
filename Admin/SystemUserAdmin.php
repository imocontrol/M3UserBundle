<?php
namespace IMOControl\M3\UserBundle\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use IMOControl\M3\UserBundle\Model\Interfaces\SystemUserInterface as UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Knp\Menu\ItemInterface as MenuItemInterface;

use IMOControl\M3\AdminBundle\Admin\Admin as CoreAdmin;

class SystemUserAdmin extends CoreAdmin
{
    protected $user_manager = null;
    
    protected $formOptions = array(
        'validation_groups' => 'Profile'
    );

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('groups')
            ->add('enabled', null, array('editable' => true))
            ->add('locked', null, array('editable' => true))
            ->add('created_at')
        ;

        if ($this->isGranted('ROLE_ALLOWED_TO_SWITCH')) {
            $listMapper
                ->add('impersonating', 'string', array('template' => 'SonataUserBundle:Admin:Field/impersonating.html.twig'))
            ;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('id')
            ->add('username')
            ->add('locked')
            ->add('email')
            ->add('groups')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General')
                ->add('username')
                ->add('email')
            ->end()
            ->with('Groups')
                ->add('groups')
            ->end()
            ->with('Profile')
                ->add('gender')
                ->add('firstname')
                ->add('lastname')
                ->add('birthday')
                ->add('website')
                ->add('locale')
                ->add('timezone')
                ->add('phone')
            ->end()
            ->with('Security')
                ->add('token')
                ->add('twoStepVerificationCode')
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('username')
                ->add('email')
                ->add('plainPassword', 'text', array('required' => false))
            ->end()
            ->with('Groups')
                ->add('groups', 'sonata_type_model', array('required' => false, 'expanded' => true, 'multiple' => true))
            ->end()
            ->with('Profile')
            	->add('gender', 'choice', array(
                    'choices' => array(
                        UserInterface::GENDER_UNKNOWN => 'gender_unknown',
                        UserInterface::GENDER_FEMALE  => 'gender_female',
                        UserInterface::GENDER_MAN     => 'gender_male',
                    ),
                    'required' => true,
                    'translation_domain' => $this->getTranslationDomain()
                ))
                ->add('salutation', null, array('required' => false))
                ->add('firstname', null, array('required' => false))
                ->add('lastname', null, array('required' => false))
                ->add('birthday', 'birthday', array('required' => false))
                ->add('website', 'url', array('required' => false))
                ->add('locale', 'locale', array('required' => false))
                ->add('timezone', 'timezone', array('required' => false))
                ->add('phone', null, array('required' => false))
            ->end()
            ->with('Systeminfos')
            	->add('created_at', 'datetime', array('required'=> false, 'read_only'=> true))
            	->add('updated_at', 'datetime', array('required'=> false, 'read_only'=> true))
            	->add('locked', null, array('required' => false))
            	->add('token')
            ->end()
        ;

        if ($this->getSubject() && !$this->getSubject()->hasRole('ROLE_SUPER_ADMIN')) {
            $formMapper
                ->with('Management')
                    ->add('realRoles', 'sonata_security_roles', array(
                        'expanded' => true,
                        'multiple' => true,
                        'required' => false
                    ))
                    ->add('locked', null, array('required' => false))
                    ->add('expired', null, array('required' => false))
                    ->add('enabled', null, array('required' => false))
                    ->add('credentialsExpired', null, array('required' => false))
                ->end()
            ;
        }

        $formMapper
            ->with('Security')
                ->add('token', null, array('required' => false))
                ->add('twoStepVerificationCode', null, array('required' => false))
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($user)
    {
        $this->getUserManager()->updateCanonicalFields($user);
        $this->getUserManager()->updatePassword($user);
    }

    /**
     * @param UserManagerInterface $userManager
     */
    public function setUserManager(UserManagerInterface $user_manager)
    {
        $this->user_manager = $user_manager;
    }

    /**
     * @return UserManagerInterface
     */
    public function getUserManager()
    {
        return $this->user_manager;
    }
}

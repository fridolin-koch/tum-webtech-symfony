<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\TimeEstimateTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Regex;

class TaskType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', 'textarea', [
                'attr' => [
                    'placeholder' => 'Enter a description of the Task...',
                    'class' => 'form-description'
                ]
            ])
            ->add('dueDate', 'date', [
                'required' => false
            ]);
        //time estimated field
        $builder->add(
            $builder
                ->create('timeEstimated', 'text', [
                    'required' => false,
                    'label' => 'Estimated time (Format: 1h30 => 1,5h)'
                ])
                ->addViewTransformer(new TimeEstimateTransformer())
        );
        $builder
            ->add('priority')
            ->add('type')
            ->add('state')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Task'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_task';
    }
}

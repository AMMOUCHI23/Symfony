<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet',TextType::class,[
                'attr'=>[
                    'class'=>"form-control",
                    'minlength'=>'2',
                    'maxlength'=>'50'
                ],
                'label'=>'Objet',
                'label_attr'=>[
                   'class'=>"form-label mt-4"
                ]
            ])
            ->add('email', EmailType::class, [
                'attr'=>[
                    'class'=>"form-control",
                    
                ],
                'label'=>'Email',
                'label_attr'=>[
                   'class'=>"form-label mt-4"
                ]
                
                ]
            )
            //On a rajouté un label et on a rendu le champ optionnel en
            // donnant la valeur false à l'attribut required
            ->add('message', TextareaType::class, [
                'attr'=>[
                    'class'=>"form-control",
                    'minlength'=>'2',
                    'maxlength'=>'300'
                ],
                'label'=>'Votre message',
                'label_attr'=>[
                   'class'=>"form-label mt-4"
                ]
                ]
            )
            ->add('save', SubmitType::class, [
                'attr'=>[
                    'class'=>"btn btn-primary mt-4 "
                  
                ],
                'label'=>'Envoyer votre message'
             
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}

<?php
/*
 * This file is part of the Krator\StreamModule package.
 *
 * Copyright Krator.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krator\StreamModule\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zikula\Bundle\CoreBundle\Translation\TranslatorTrait;

use Krator\StreamModule\AppSettings;

/**
 * Configuration form type implementation class.
 */
class ConfigType extends AbstractType
{
    use TranslatorTrait;
	
	public function __construct(
        TranslatorInterface $translator
    ) {
        $this->setTranslator($translator);
    }

	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('clientId', TextType::class, [
            'label' => $this->trans('Client Id') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->trans('Client Id from Twitch')
            ],
            'attr' => [
                'maxlength' => 30,
                'class' => '',
                'title' => $this->trans('Get this information from https://dev.twitch.tv/console')
            ],
            'required' => true
        ]);
		
		$builder->add('clientSecret', TextType::class, [
            'label' => $this->trans('Client Secret') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->trans('Client Secret from Twitch')
            ],
            'attr' => [
                'maxlength' => 30,
                'class' => '',
                'title' => $this->trans('Get this information from https://dev.twitch.tv/console')
            ],
            'required' => true
        ]);
		
		$builder->add('thumbBlockWidth', IntegerType::class, [
            'label' => $this->trans('Width of thumbnail for the block') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->trans('Width in pixel of the image showed in the block')
            ],
            'help' => $this->trans('Width in pixel of the image showed for the block'),
            'empty_data' => 80,
            'attr' => [
                'maxlength' => 4,
                'class' => '',
                'title' => $this->trans('Enter the width.') . ' ' . $this->trans('Only digits are allowed.')
            ],
            'required' => true,
            //'scale' => 0
        ]);

		$builder->add('thumbBlockHeight', IntegerType::class, [
            'label' => $this->trans('Height of thumbnail for the block') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->trans('Height in pixel of the image showed in the block')
            ],
            'help' => $this->trans('Height in pixel of the image showed for the block'),
            'empty_data' => 80,
            'attr' => [
                'maxlength' => 4,
                'class' => '',
                'title' => $this->trans('Enter the height.') . ' ' . $this->trans('Only digits are allowed.')
            ],
            'required' => true,
            //'scale' => 0
        ]);
		
		$builder->add('thumbStreamWidth', IntegerType::class, [
            'label' => $this->trans('Width of thumbnail of a stream') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->trans('Width in pixel of the image showed for a stream')
            ],
            'help' => $this->trans('Width in pixel of the image showed for a stream'),
            'empty_data' => 260,
            'attr' => [
                'maxlength' => 4,
                'class' => '',
                'title' => $this->trans('Enter the width.') . ' ' . $this->trans('Only digits are allowed.')
            ],
            'required' => true,
            //'scale' => 0
        ]);

		$builder->add('thumbStreamHeight', IntegerType::class, [
            'label' => $this->trans('Height of thumbnail of a stream') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->trans('Height in pixel of the image showed for a stream')
            ],
            'help' => $this->trans('Height in pixel of the image showed for a stream'),
            'empty_data' => 180,
            'attr' => [
                'maxlength' => 4,
                'class' => '',
                'title' => $this->trans('Enter the height.') . ' ' . $this->trans('Only digits are allowed.')
            ],
            'required' => true,
            //'scale' => 0
        ]);
		
		$builder->add('streamWidth', IntegerType::class, [
            'label' => $this->trans('Width of the player of a stream') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->trans('Width in pixel of the player stream')
            ],
            'help' => $this->trans('Width in pixel of the player stream'),
            'empty_data' => 1280,
            'attr' => [
                'maxlength' => 4,
                'class' => '',
                'title' => $this->trans('Enter the width.') . ' ' . $this->trans('Only digits are allowed.')
            ],
            'required' => true,
            //'scale' => 0
        ]);

		$builder->add('streamHeight', IntegerType::class, [
            'label' => $this->trans('Height of the player of a stream') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->trans('Height in pixel of the player stream')
            ],
            'help' => $this->trans('Height in pixel of the player stream'),
            'empty_data' => 720,
            'attr' => [
                'maxlength' => 4,
                'class' => '',
                'title' => $this->trans('Enter the height.') . ' ' . $this->trans('Only digits are allowed.')
            ],
            'required' => true,
            //'scale' => 0
        ]);

		$builder->add('streamsBlock', IntegerType::class, [
            'label' => $this->trans('Number of streams in block') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->trans('Number of streams in block')
            ],
            'help' => $this->trans('Number of streams that could be showed in the block'),
            'empty_data' => 5,
            'attr' => [
                'maxlength' => 2,
                'class' => '',
                'title' => $this->trans('Enter the number.') . ' ' . $this->trans('Only digits are allowed.')
            ],
            'required' => true,
            //'scale' => 0
        ]);
		
		$builder->add('favLang', TextType::class, [
            'label' => $this->trans('Favorite Languages') . ':',
            'label_attr' => [
                'class' => 'tooltips',
                'title' => $this->trans('Client Secret from Twitch')
            ],
			'help' => $this->trans('Languages ISO Code separated by , (comma)'),
            'attr' => [
                'maxlength' => 20,
                'class' => '',
                'title' => $this->trans('Get this information from https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes')
            ],
            'required' => true
        ]);
		
        $this->addSubmitButtons($builder, $options);
    }
	
	/**
     * Adds submit buttons.
     */
    public function addSubmitButtons(FormBuilderInterface $builder, array $options = [])
    {
        $builder->add('save', SubmitType::class, [
            'label' => $this->trans('Update configuration'),
            'icon' => 'fa-check',
            'attr' => [
                'class' => 'btn btn-success'
            ]
        ]);
        $builder->add('reset', ResetType::class, [
            'label' => $this->trans('Reset'),
            'icon' => 'fa-refresh',
            'attr' => [
                'class' => 'btn btn-default',
                'formnovalidate' => 'formnovalidate'
            ]
        ]);
        $builder->add('cancel', SubmitType::class, [
            'label' => $this->trans('Cancel'),
            'icon' => 'fa-times',
            'attr' => [
                'class' => 'btn btn-default',
                'formnovalidate' => 'formnovalidate'
            ]
        ]);
    }

    public function getBlockPrefix()
    {
        return 'kratorstreammodule_config';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                // define class for underlying data
                'data_class' => AppSettings::class,
            ]);
    }
}

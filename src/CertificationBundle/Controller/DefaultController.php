<?php


namespace CertificationBundle\Controller;

use AppBundle\Exception\StrunzException;
use CertificationBundle\Entity\CustomConstraintExample;
use CertificationBundle\Entity\SerializableEntity;
use CertificationBundle\Entity\ValidationExample;
use CertificationBundle\Event\MaluEvent;
use CertificationBundle\MaluService\ManualWiring;
use CertificationBundle\MaluService\ParameterInjection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="certification_index")
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('certification/index.html.twig');
    }

    /**
     * @Route("/exception/", name="certification_exception")
     */
    public function exceptionAction()
    {

        throw new StrunzException();

    }

    /**
     * @Route("/dispatcher/", name="certification_dispatcher")
     */
    public function dispatcherAction(EventDispatcherInterface $dispatcher)
    {
        // Tried to inject the dispatcher into the action; don't know why it doesn't work ...
        // update: found out the reason -> controllers for this bundle didn't have the 'controller.service_arguments' tag in service.yml
        //$dispatcher->addSubscriber($this->get(MaluEventSubscriber::class));

        $dispatcher->dispatch('malu.event', new MaluEvent('Man, so eventful in here.'));

        $this->addFlash('notice', 'malu.event dispatched');

        return $this->render('certification/index.html.twig');
    }

    /**
     * @Route("/service/parameter-injection", name="certification_service_parameter_injection")
     */
    public function serviceParameterInjectionAction(ParameterInjection $pi)
    {
        $this->addFlash('notice', $pi->getMail() . " (I was injected as an argument into a service)");

        $this->addFlash('notice', $this->getParameter('parameter_injection_mail') . " (I was fetched directly as a parameter)");

        return $this->render('certification/index.html.twig');
    }

    /**
     * @Route("/service/manuel-wiring", name="certification_service_manuel_wiring")
     */
    public function manuelWiringAction(ManualWiring $mw)
    {
        $this->addFlash('notice', $mw->getUser() . " (taken from the service alias that point to the standard user service)");

        $mwsuper = $this->get('malu.manuelwiring.superuser');

        $this->addFlash('notice', $mwsuper->getUser() . " (taken from the superuser service)");

        return $this->render('certification/index.html.twig');
    }

    /**
     * @Route("/service/manuel-configuration", name="certification_service_manuel_configuration")
     */
    public function manuelConfigurationAction(EventDispatcherInterface $dispatcher)
    {
        $dispatcher->dispatch('malu.manualconfiguration.event');


       // $this->addFlash('notice', $mw->getUser() . " (taken from the service alias that point to the standard user service)");


       // $this->addFlash('notice', $mwsuper->getUser() . " (taken from the superuser service)");

        return $this->render('certification/index.html.twig');
    }

    /**
     * @Route("/service/basic-validation", name="certification_basic_validation")
     */
    public function basicValidationAction(Request $request){
        $form = $this->createForm(FormType::class);
        $form
            ->add('input', TextType::class,
                [
                    'required' => false,
                    'label' => 'Needs to be at least 3 chars long',
                    'constraints' => [
                        new Length(['min' => 3])
                    ]
                ]
            )
            ->add('input2', TextType::class,
                [
                    'required' => false,
                    'label' => 'Number between 4 and 7',
                    'constraints' => [
                        new Range(['min' => 4, 'max' => 7])
                    ]
                ]
            )
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);

        dump($form);

        $this->addFlash('notice', 'Is form valid? ->' . $form->isValid());

        return $this->render('certification/index.html.twig', ['form_default_validation' => $form->createView()]);
    }

    /**
     * @Route("/service/php-object-validation", name="certification_php_object_validation")
     */
    public function phpObjectValidationExampleAction(Request $request, ValidationExample $validationExample){

        $form = $this->createForm(FormType::class, $validationExample);
        $form
            ->add('name', TextType::class, ['required' => false])
            ->add('submit', SubmitType::class);
        $form->handleRequest($request);

        dump($validationExample);
        dump($form);

        $this->addFlash('notice', 'Is form valid? ->' . $form->isValid());

        return $this->render('certification/index.html.twig', ['form_php_object_validation' => $form->createView()]);

    }

    /**
     * @Route("/service/custom-constraint", name="certification_custom_constraint")
     */
    public function customConstraintAction(Request $request, CustomConstraintExample $cce){

        $form = $this->createForm(FormType::class, $cce);

        $form->add('title', TextType::class, ['required' => false])
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);

        return $this->render('certification/index.html.twig', ['form_custom_constraint' => $form->createView()]);

    }

    /**
     * @Route("/service/custom-constraint-and-group", name="certification_custom_constraint_and_group")
     */
    public function groupValidationAction(Request $request, CustomConstraintExample $cce){

        $form = $this->createForm(
            FormType::class,
            $cce,
            ['validation_groups' => ['malugroup']]
        );

        $form
            ->add('secondTitle', TextType::class, ['required' => false])
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);

        return $this->render('certification/index.html.twig', ['form_custom_constraint_and_group' => $form->createView()]);

    }

    /**
     * @Route("/service/custom-constraint-and-group-and-sequence", name="certification_custom_constraint_and_group_and_sequence")
     */
    public function groupSequenceValidationAction(Request $request, CustomConstraintExample $cce){

        $form = $this->createForm(
            FormType::class,
            $cce,
            ['validation_groups' => ['malugroup', 'maluSecondGroup']]
        );

        $form
            ->add('secondTitle', TextType::class, ['required' => false])
            ->add('thirdTitle', TextType::class, ['required' => false])
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);

        return $this->render('certification/index.html.twig', ['form_custom_constraint_and_group_and_sequence' => $form->createView()]);

    }

    /**
     * @Route("/serializer", name="certification_serializer")
     */
    public function serializerAction(){
        $se = new SerializableEntity();
      //  $se->setName('heinz');
      //  $se->setNumber(12345);
      //  $se->setIsAwesome(false);

        $data = <<<EOF
<person>
    <awesome>0</awesome>
    <name>heinz</name>
    <number>123456</number>
</person>
EOF;

        $encoders = [new JsonEncoder(), new XmlEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $serializer->deserialize($data, SerializableEntity::class, 'xml', array('object_to_populate' => $se));

        $json = $serializer->serialize($se, 'json');
        $xml = $serializer->serialize($se, 'xml');

        return $this->render('certification/index.html.twig',
            [
                'serialized_json' => $json,
                'serialized_xml' => $xml]
        );
    }

    /**
     * @Route("/process", name="certification_process")
     */
    public function processAction(){

        $process = new Process('ls -la');
        $process->run();

        return $this->render('certification/index.html.twig', ['process_output' => $process->getOutput()]);

    }

    /**
     * @Route("/data-collector", name="certification_data_collector")
     */
    public function dataCollectorAction(){
        return $this->render('certification/index.html.twig');
    }

}
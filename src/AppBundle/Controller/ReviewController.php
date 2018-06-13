<?php
/**
 * Created by PhpStorm.
 * User: m0rsak
 * Date: 16/05/18
 * Time: 17:41
 */


namespace AppBundle\Controller;

use AppBundle\Entity\Review;
use AppBundle\Form\ReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;



/**
 * Class ReviewController
 * @package AppBundle\Controller
 *
 * @route("review")
 */

Class ReviewController extends Controller
{
        /**
         * Lists all review entities.
         *
         * @Route("/", name="review_index")
         * @Method("GET")
         */
        public function indexAction()
        {
        $em = $this->getDoctrine()->getManager();

        $reviews = $em->getRepository('AppBundle:Review')->findAll();

        return $this->render('review/index.html.twig', array(
            'reviews' => $reviews,
        ));
        }



    /**
     * @Route("/new", name="review_new")
     * @Method({"GET", "POST"})
     *
     */
    public function newAction(Request $request)
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);

        dump($form);
        // build the form ...

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            // You can use too :
            // return $this->redirect($this->generateUrl('review_show', array('id' => $review->getId())))

            return $this->redirectToRoute('review_show', array('id' => $review->getId()));
        }

        return $this->render('review/new.html.twig', array(
            'review' => $review,
            'form' => $form->createView(),
        ));

    }

    /**
     * Finds and displays a review entity.
     *
     * @Route("/{id}", name="review_show")
     * @Method("GET")
     */
    public function showAction(review $review)
    {
        $deleteForm = $this->createDeleteForm($review);

        return $this->render('review/show.html.twig', array(
            'review' => $review,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing review entity.
     *
     * @Route("/{id}/edit", name="review_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, review $review)
    {
        $deleteForm = $this->createDeleteForm($review);
        $editForm = $this->createForm('AppBundle\Form\ReviewType', $review);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('review_edit', array('id' => $review->getId()));
        }

        return $this->render('review/edit.html.twig', array(
            'review' => $review,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a review entity.
     *
     * @Route("/{id}", name="review_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, review $review)
    {
        $form = $this->createDeleteForm($review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($review);
            $em->flush();
        }

        return $this->redirectToRoute('review_index');
    }

    /**
     * Creates a form to delete a review entity.
     *
     * @param review $review The review entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(review $review)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('review_delete', array('id' => $review->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}


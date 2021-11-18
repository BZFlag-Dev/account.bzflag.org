<?php
/*
 * BZFlag Accounts - Manage accounts and organizations for BZFlag
 * Copyright (C) 2021  BZFlag & Associates
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Controller;

use App\Form\COPPAType;
use App\Form\DOBType;
use App\Form\LoginType;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountManagementController extends AbstractController
{
    /**
     * @Route("/login", name="account_management_login")
     */
    public function login(Request $request): Response
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            header('Content-Type: text/plain'); print_r($data); exit;
        }

        return $this->renderForm('account_management/login.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/register", name="account_management_register")
     */
    public function register(Request $request): Response
    {
        // A session will be used to track the Date of Birth
        $session = $request->getSession();

        // Try to fetch the Date of Birth
        $dateOfBirth = $session->get('dateOfBirth', false);

        // If it was not set, prompt the user for it
        if (!$dateOfBirth) {
            $form = $this->createForm(DOBType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $dateOfBirth = $data['dateOfBirth'];
                $session->set('dateOfBirth', $dateOfBirth);
            } else {
                return $this->renderForm('account_management/dob.html.twig', [
                    'form' => $form,
                ]);
            }
        }

        // If the user is under the age of 13, run through the COPPA process
        if ($dateOfBirth->diff(new \DateTime)->y < 13) {
            $form = $this->createForm(COPPAType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                // TODO: Decide how we'll handle COPPA requests. Some ideas:
                //   - Email link that provides a printable form and a file upload field
                //   - Email link that provides a signable form in the browser
                //$email = $data['parentGuardianEmail'];
                $session->remove('dateOfBirth');
                header('Content-Type: text/plain'); print_r($data); exit;
            }

            return $this->renderForm('account_management/coppa.html.twig', [
                'form' => $form
            ]);
        }
        else {
            $form = $this->createForm(RegisterType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();

                header('Content-Type: text/plain'); print_r($data); exit;
            }

            return $this->renderForm('account_management/register.html.twig', [
                'form' => $form
            ]);
        }
    }
}

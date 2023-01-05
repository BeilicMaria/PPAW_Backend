<?php

namespace App\Utils;

class ErrorAndSuccessMessages
{
    const unavailableUserName = "Utilizatorul nu este disponibil.";
    const invalidUserName = "Utilizatorul este greșit.";
    const invalidEmail = "Email greșit.";
    const failedRegistration = "Înregistrarea nu a avut succes.";
    const successRegistration = "Solicitarea a fost înregistrată cu succes! Revenim în curând.";
    const invalidUserRole = "Rolul utilizatorului este incorect.";
    const invalidPassword = "Parola este greșită.";
    const loginFailed = "Autentificarea nu a avut succes.";
    const logoutSuccess = "Deconectarea a avut succes!";
    const logoutFailed = "Deconectarea nu a avut succes.";
    const invalidDocumentId = "Documentul selectată nu exista. ";
    const updateDocumentFailed = "Actualizarea nu se poate efectua.";
    const insertOrUpdateDocumentFailed = "Adăugarea sau actualizarea documentului a eșuat.";
    const deleteDocumentsSuccess = "Documentul/ documentele au fost șterse cu succes.";
    const deleteDocumentsFailed = "Ștergerea documentului/ documentelor a eșuat.";
    const getDataFailed = "Colectarea datalor a eșuat.";
    const passwordChangeFailed = "Schimbarea parolei a eșuat.";
    const blankFields = "Toate câmpurile sunt obligatorii!";
    const invalidUserAndPassword = "Parola sau utilizatorul este incorect.";
    const passwordChangeSuccess = "Parola a fost schimbată cu succes.";
    const addTemplateFailed = " Adăugarea șablonului a eșuat.";
    const addFileFailed = "Nu să adăugat un fișier!";
    const templateWithIncorrectExtension = "Extensia șablonului trebuie să fie doc sau docx!";
    const addTemplateSuccess = "Șablonul a fost adăugat cu succes.";
    const saveFileFailed = "Fișierul nu a fost salvat cu succes.";
    const deleteFileSuccess = "Fișierele au fost șterse cu succes.";
    const deleteFileFailed = "Fișierele nu au fost șterse cu succes.";
    const fileDoesNotExist = "Fișierele selectate nu există.";
    const incompleteInput = "Nu au fost completate toate câmpurile";
    const missingTemplate = "Nu există șablon pentru scopul precizat.";
    const validationError = "Eroare la validatrea datelor.";
    const deleteFailed = "Ștergerea a eșuat.";
    const deleteSuccess = "Ștergerea a fost finalizată cu succes.";
    const invalidRecaptcha = "Invalid recaptcha.";
    const timeoutError = "Ai introdus o parolă greșită de 3 ori. Încercările de conectare sunt blocate pentru o perioada de 2 minute. Timp rămas : ";
    const registerConfirmationSubject = "Confirmare cerere de înregistrare";
    const registerConfirmationMessage = "Îți mulțumim că ai ales platforma VETMED. Îți vom trimite o confirmare de îndată ce cererea ta va fi procesată.";
    const newRegister = "Solicitare nouă";
}

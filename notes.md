

5. Page d'Inscription
- make:controller RegistrationController

6. Formulaire d'Inscription 
=> https://symfony.com/doc/current/forms.html (Installer avant tout les composer du formulaire)
Pour gérer le formulaire d'Inscription dans le fichier TWIG, on ouvre une "Public Function" avec les parametre suivants : 
- La fonction "register" sert à traiter une requête HTTP de type "POST" qui permet d'enregistrer un nouvel utilisateur dans une application. 
- Elle prend en paramètres un objet de type "Request" qui contient toutes les informations envoyées dans la requête, 
- Une instance de l'interface "UserPasswordHasherInterface" pour hasher le mot de passe de l'utilisateur et une instance de l'interface "EntityManagerInterface" pour gérer les opérations de persistance en base de données. L'entity manager permet les opératiosn SQL : ajouter, supprimer, update, etc. 


7. Pour appliquer du style au input du formulaire 
Coller le theme bootstrap dans config/packages/twig.yaml
=> form_themes: ['bootstrap_5_layout.html.twig']

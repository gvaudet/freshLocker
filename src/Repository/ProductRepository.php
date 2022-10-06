<?php

namespace App\Repository;

use App\Classes\Search;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Requete qui permet de récupérer les produits en fonction de la recherche de l'utilisateur 
     * @return Product 
     */
    public function findWithSearch(Search $search)
    {
        $query = $this
        // On commence par créer une query et on déclare avec quelle table la query (mapping) est créée 'p' pour Product (Doctrine fait gagner du temps)
                ->createQueryBuilder('p')
                // Que dois-je selectionner pour la catégorie('c') et ('p') pour product
                ->select('c', 'p')
                // Faire la jointure entre les catégories de mon produit et la table Category
                ->join('p.category', 'c');
        // Lorsque des catégories ont été selectionner uniquement les catégories cochées ajouter un "where" dans la requete pour filtrer (encore un peu flou cette notion de where) 
        if(!empty($search->categories)){
            // Récuperer la query 
            $query = $query
                    // Spécifier que les ID des catégories soient dans la liste categories que j'envoie en parametre 
                    ->andWhere('c.id IN (:categories)')
                    // déclarer le param 'categories' avec sa valeur 
                    ->setParameter('categories', $search->categories);
        }
        // Même chose que les catégories pour la barre de recherche avec le paramètre 'string' de la class Search()
        if(!empty($search->string)){
            $query = $query
                    // Permet de voir si le nom du produit (p.label)
                    ->andWhere('p.label LIKE :string')
                    // "%{}%" permet de faire une recherche partielle 
                    ->setParameter('string', "%{$search->string}%");
        }

        return $query->getQuery()->getResult(); 
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

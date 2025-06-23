<?php

/**
 * Item fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Item;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

/**
 * Class ItemFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class ItemFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if (!$this->manager instanceof ObjectManager || !$this->faker instanceof Generator) {
            return;
        }
        $this->createMany(40, 'items', function (int $i) {
            $item = new Item();
            $item->setTitle($this->faker->sentence);
            $item->setDescription($this->faker->text);
            $item->setCreatedAt(
                \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $category = $this->getRandomReference('category', Category::class);
            $item->setCategory($category);

            return $item;
        });
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: CategoryFixtures::class}
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}

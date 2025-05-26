<?php

/**
 * Item fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Item;

/**
 * Class ItemFixtures.
 */
class ItemFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $item = new Item();
            $item->setTitle($this->faker->sentence);
            $item->setDescription($this->faker->text);
            $item->setCreatedAt(
                \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $this->manager->persist($item);
        }

        $this->manager->flush();
    }
}

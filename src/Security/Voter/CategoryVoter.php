<?php

/**
 * Category voter.
 */

namespace App\Security\Voter;

use App\Entity\Category;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CategoryVoter.
 */
final class CategoryVoter extends Voter
{
    /**
     * Delete permission.
     *
     * @const string
     */
    public const DELETE = 'CATEGORY_DELETE';

    /**
     * Edit permission.
     *
     * @const string
     */
    public const EDIT = 'CATEGORY_EDIT';

    /**
     * View permission.
     *
     * @const string
     */
    public const VIEW = 'CATEGORY_VIEW';

    /**
     * Create permission.
     *
     * @const string
     */
    public const CREATE = 'CATEGORY_CREATE';

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed  $subject   The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool Result
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE, self::VIEW, self::CREATE])
            && ($subject instanceof Category || self::CREATE === $attribute);
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string         $attribute Permission name
     * @param mixed          $subject   Object
     * @param TokenInterface $token     Security token
     *
     * @return bool Vote result
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        return match ($attribute) {
            self::EDIT, self::DELETE, self::CREATE => in_array('ROLE_ADMIN', $user->getRoles(), true),
            self::VIEW => true,
            default => false,
        };
    }
}

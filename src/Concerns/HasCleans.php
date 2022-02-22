<?php


namespace BiiiiiigMonster\Cleans\Concerns;


use BiiiiiigMonster\Cleans\Cleaner;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait HasCleans
 *
 * @property array $cleans The relationships that will be auto-cleaned when deleted.
 * @property bool $cleanWithSoftDelete Determine if propagate soft delete to the cleans.
 * @property string|null $cleanQueue Execute clean use the queue.
 * @package BiiiiiigMonster\Cleans\Concerns
 */
trait HasCleans
{
    /**
     * Auto register cleans.
     */
    protected static function bootHasCleans(): void
    {
        static::deleted(static fn(Model $model) => Cleaner::make($model)->handle());
        if (Cleaner::hasSoftDeletes(static::class)) {
            static::forceDeleted(static fn(Model $model) => Cleaner::make($model)->handle(true));
        }
    }

    /**
     * Get cleans.
     *
     * @return array
     */
    public function getCleans(): array
    {
        return $this->cleans ?? [];
    }

    /**
     * Set the cleans attributes for the model.
     *
     * @param array $cleans
     * @return $this
     */
    public function setCleans(array $cleans): static
    {
        $this->cleans = $cleans;

        return $this;
    }

    /**
     * Make the given, typically visible, attributes cleans.
     *
     * @param array|string|null $cleans
     * @return $this
     */
    public function clean(array|string|null $cleans): static
    {
        $this->cleans = array_merge(
            $this->getCleans(), is_array($cleans) ? $cleans : func_get_args()
        );

        return $this;
    }

    /**
     * Get cleanWithSoftDelete.
     *
     * @return bool
     */
    public function isCleanWithSoftDelete(): bool
    {
        return $this->cleanWithSoftDelete ?? false;
    }

    /**
     * Set the cleanWithSoftDelete attributes for the model.
     *
     * @param bool $cleanWithSoftDelete
     * @return $this
     */
    public function setCleanWithSoftDelete(bool $cleanWithSoftDelete): static
    {
        $this->cleanWithSoftDelete = $cleanWithSoftDelete;

        return $this;
    }

    /**
     * Get cleanQueue.
     *
     * @return string|null
     */
    public function getCleanQueue(): ?string
    {
        return $this->cleanQueue;
    }

    /**
     * Set the cleanQueue attributes for the model.
     *
     * @param string|null $cleanQueue
     * @return $this
     */
    public function setCleanQueue(?string $cleanQueue): static
    {
        $this->cleanQueue = $cleanQueue;

        return $this;
    }
}
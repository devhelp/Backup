<?php

namespace Devhelp\Component\Backup;

/**
 * Class BackupEvent
 * @author <michal@devhelp.pl>
 */
final class BackupEvents
{
    /**
     * The RUN_PROCESS event is dispatched before starting backup process
     */
    const RUN_PROCESS = "backup.run_process";

    /**
     * The INTERRUPT_PROCESS event is dispatched during backup running
     * when exception has been thrown
     */
    const INTERRUPT_PROCESS = "backup.interrupt_process";

    /**
     * The ERROR_READ_RESOURCE event is dispatched when remote resource
     * cannot be read
     */
    const ERROR_READ_RESOURCE = "backup.error_read_resource";

    /**
     * The ERROR_WRITE_RESOURCE event is dispatched when local resource
     * cannot be written
     */
    const ERROR_WRITE_RESOURCE = "backup.error_write_resource";

    /**
     * The STEP_PROCESS event is dispatched during backup loop after successfully
     * stored file
     */
    const STEP_PROCESS = "backup.step_process";

    /**
     * The FINISH_PROCESS event is dispatched after successfully finished backup process
     */
    const FINISH_PROCESS = "backup.finish_process";

}

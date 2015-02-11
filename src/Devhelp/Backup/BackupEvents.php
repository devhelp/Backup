<?php

namespace Devhelp\Backup;

/**
 * @author <michal@devhelp.pl>
 */
final class BackupEvents
{
    const RUN_PROCESS_EVENT = 'backup.run_process_event';
    const FINISH_PROCESS_EVENT = 'backup.finish_process_event';
    const NOTIFY_ERROR_READING_EVENT = 'backup.notify_error_reading_event';
    const NOTIFY_ERROR_WRITING_EVENT = 'backup.notify_error_writing_event';
    const NOTIFY_SUCCESS_STEP_EVENT = 'backup.notify_success_step_event';
}
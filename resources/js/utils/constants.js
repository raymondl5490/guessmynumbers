const ATTEMPT_STATUS = Object.freeze({
    MODE: Object.freeze({
        REGULAR: Symbol('REGULAR'),
        PRACTICE: Symbol('PRACTICE'),
    }),
    STATUS: Object.freeze({
        RUNNING: Symbol('RUNNING'),
        ENDED: Object.freeze({
            WIN: Object.freeze({
                TRY_1: Symbol('TRY_1'),
                TRY_2: Symbol('TRY_2'),
                TRY_3: Symbol('TRY_3'),
            }),
            LOSE: Object.freeze({
                CORRECT_0: Symbol('CORRECT_0'),
                CORRECT_1: Symbol('CORRECT_1'),
                CORRECT_2: Symbol('CORRECT_2'),
            }),
        }),
    }),
});

const ATTEMPT_STATUS_CODES = Object.freeze({
    MODE_REGULAR: Symbol('MODE_REGULAR'),
    MODE_PRACTICE: Symbol('MODE_PRACTICE'),

    STATUS_RUNNING: Symbol('STATUS_RUNNING'),

    STATUS_ENDED: Symbol('STATUS_ENDED'),
    STATUS_ENDED_WIN: Symbol('STATUS_ENDED_WIN'),
    STATUS_ENDED_WIN_1: Symbol('STATUS_ENDED_WIN_1'),
    STATUS_ENDED_WIN_2: Symbol('STATUS_ENDED_WIN_2'),
    STATUS_ENDED_WIN_3: Symbol('STATUS_ENDED_WIN_3'),

    STATUS_ENDED_LOSE: Symbol('STATUS_ENDED_LOSE'),
    STATUS_ENDED_LOSE_0: Symbol('STATUS_ENDED_LOSE_0'),
    STATUS_ENDED_LOSE_1: Symbol('STATUS_ENDED_LOSE_1'),
    STATUS_ENDED_LOSE_2: Symbol('STATUS_ENDED_LOSE_2'),
});

const SETTING_KEYS = [
    'result_text_win_try_1',
    'result_text_win_try_2',
    'result_text_win_try_3',
    'result_text_lose_correct_0',
    'result_text_lose_correct_1',
    'result_text_lose_correct_2',
];

const SETTING_DISPLAY_NAME_BY_KEY = {
    'result_text_win_try_1': 'WIN IN FIRST TRY',
    'result_text_win_try_2': 'WIN IN SECOND TRY',
    'result_text_win_try_3': 'WIN IN THIRD TRY',
    'result_text_lose_correct_0': 'LOSE CORRECT 0',
    'result_text_lose_correct_1': 'LOSE CORRECT 1',
    'result_text_lose_correct_2': 'LOSE CORRECT 2',
};

const SQUARE_STATUS_CODES = Object.freeze({
    NO_NUMBER: Symbol('NO_NUMBER'),

    NOT_SUBMITTED: Symbol('NOT_SUBMITTED'),

    SUBMITTED: Symbol('SUBMITTED'),
    SUBMITTED_INCORRECT: Symbol('SUBMITTED_INCORRECT'),
    SUBMITTED_CORRECT: Symbol('SUBMITTED_CORRECT'),
    SUBMITTED_CORRECT_WRONG_SPOT: Symbol('SUBMITTED_CORRECT_WRONG_SPOT'),
    SUBMITTED_CORRECT_RIGHT_SPOT: Symbol('SUBMITTED_CORRECT_RIGHT_SPOT'),
});

export {
    ATTEMPT_STATUS_CODES,
    SETTING_DISPLAY_NAME_BY_KEY,
    SQUARE_STATUS_CODES,
}
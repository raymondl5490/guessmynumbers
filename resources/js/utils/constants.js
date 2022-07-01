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

export {
    ATTEMPT_STATUS_CODES,
}
/**
 * Public studio contacts, stored as character codes.
 *
 * The address and number are assembled in the browser so they are not written
 * as plain text in the HTML. Replace the codes if the published details change.
 * The phone below is a placeholder (all zeros) until the studio number is set.
 */
function decode(codes: readonly number[]): string {
    return String.fromCharCode(...codes);
}

export function studioEmail(): string {
    return decode([
        105, 110, 102, 111, 64, 115, 105, 116, 101, 115, 116, 97, 114, 46, 98,
        121,
    ]);
}

export function studioPhoneDisplay(): string {
    return decode([
        43, 51, 55, 53, 32, 49, 55, 32, 48, 48, 48, 45, 48, 48, 45, 48, 48,
    ]);
}

export function studioPhoneTel(): string {
    return decode([43, 51, 55, 53, 49, 55, 48, 48, 48, 48, 48, 48, 48]);
}

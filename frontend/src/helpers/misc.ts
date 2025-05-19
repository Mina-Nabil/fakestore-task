
/**
 * Format a float number to 2 decimal places - Use it on all prices to prevent floating point precision issues and keep the UI clean
 * @param number - The number to format
 * @returns The formatted number
 */
export const formatFloatNumber = (number: number) => {
  return (Math.round(number * 100) / 100).toFixed(2)
}

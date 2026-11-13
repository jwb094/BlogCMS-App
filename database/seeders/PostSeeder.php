<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Seed a balanced set of practical, readable articles across every category.
     */
    public function run(): void
    {
        $authors = User::where('role', 'author')->get();
        $categories = Category::all()->keyBy('name');
        $images = Media::all();

        if ($authors->isEmpty() || $categories->isEmpty()) {
            return;
        }

        $articles = [
            'Technology' => [
                ['A calmer way to manage phone notifications', 'A few deliberate settings can make a phone useful without letting every app interrupt the day.', 'Start by turning off promotional alerts and keeping notifications for people and services that need a timely response. Review the list again after a week; most apps work perfectly well when checked on your schedule.'],
                ['What to check before buying a refurbished laptop', 'A refurbished computer can be a good value when its condition, warranty and return policy are clear.', 'Ask about battery health, the exact processor and memory, and whether the seller has tested the keyboard, ports and screen. A written return window matters more than a vague grade such as “excellent.”'],
                ['Making a home Wi-Fi network more reliable', 'Router placement and a little troubleshooting often solve everyday connection problems.', 'Keep the router in an open, central place rather than inside a cabinet. If one room remains slow, test it at different times and compare a wired connection before paying for a larger internet plan.'],
                ['A practical guide to backing up family photos', 'Two copies in different places make photographs easier to recover after a lost device or drive failure.', 'Use automatic phone uploads, then keep a second copy on an external drive or another trusted service. Open a few backed-up files periodically so you know the archive is readable.'],
                ['Choosing a password manager for a household', 'A shared vault can help a family keep account access organised and recoverable.', 'Compare recovery options, two-factor sign-in and secure sharing before moving passwords. Start with the most important accounts, and make sure another trusted adult understands how emergency access works.'],
                ['Understanding software update prompts', 'Updates often fix security issues and bugs, but a little preparation prevents avoidable disruption.', 'Install routine updates from the device’s settings, keep a recent backup and avoid links in unexpected messages. For work devices, follow the organisation’s support guidance before changing managed software.'],
                ['How to reduce screen glare at a desk', 'Small changes to lighting and monitor position can make a long workday more comfortable.', 'Place the screen at a right angle to bright windows and adjust room lighting before raising brightness. If discomfort continues, take regular distance breaks and check that text size is comfortable.'],
            ],
            'Programming' => [
                ['Write functions that are easier to test', 'Small functions with clear inputs and outputs are simpler to reason about and reuse.', 'Separate calculations from file, network and database access where practical. A function that handles one decision can be tested with a handful of ordinary and edge-case examples.'],
                ['Why meaningful names save debugging time', 'Names that describe intent help a future reader understand code without reconstructing every step.', 'Prefer names such as `invoiceTotal` or `retryCount` over vague abbreviations. Keep the surrounding logic straightforward too; a good name cannot rescue a function that does several unrelated jobs.'],
                ['A simple approach to handling errors', 'Useful error handling explains what failed and gives the application a safe next step.', 'Catch errors where you can add context or recover, and let unexpected failures reach the normal logging system. Avoid swallowing exceptions, because a quiet failure is often harder to diagnose than a visible one.'],
                ['Keep code reviews focused and kind', 'A review works best when it checks behaviour and maintainability without turning preferences into rules.', 'Describe the risk behind a requested change and ask a question when the intent is unclear. Small review batches are easier to understand and make it simpler for the author to respond thoughtfully.'],
                ['When to add a comment to code', 'Comments are most useful when they explain a constraint or decision that the code cannot show by itself.', 'Document surprising business rules, compatibility requirements and non-obvious trade-offs. If a comment merely repeats the next line, a clearer variable or function name is usually better.'],
                ['Use version control for everyday experiments', 'A small branch makes it safer to try an idea and compare it with the working version.', 'Commit one coherent change at a time and write a message that describes the outcome. Before sharing, inspect the diff for generated files, credentials and unrelated formatting changes.'],
                ['Make command-line tools friendlier', 'A useful command tells people what it is doing and how to correct common mistakes.', 'Validate arguments early, provide a concise help option and send errors to the appropriate output stream. For long tasks, show progress without flooding the terminal with implementation details.'],
            ],
            'Web Development' => [
                ['Designing forms that work well on a phone', 'A form is easier to complete when labels, controls and error messages fit a small screen.', 'Use the right input type, keep related fields together and avoid making users re-enter information after a validation error. Test with the on-screen keyboard open, since it can cover buttons and instructions.'],
                ['Improve page loading with smaller images', 'Image dimensions and format have a noticeable effect on how quickly a page becomes usable.', 'Resize images to the largest size they will actually appear, compress them and provide responsive variants. Keep meaningful alternative text for informative images and leave decorative images empty for assistive technology.'],
                ['Accessible navigation starts with clear links', 'People should be able to understand a link’s destination from its text and surrounding context.', 'Use descriptive labels, visible keyboard focus and a logical heading structure. Test navigation without a mouse and check that menus do not trap keyboard users.'],
                ['A sensible first API error response', 'Consistent API errors help client applications recover and help developers investigate failures.', 'Return an appropriate status code and a stable, human-readable message. Keep internal stack traces and secrets in server logs rather than exposing them in a public response.'],
                ['Why responsive layouts need real content', 'A layout that looks tidy with short placeholders can fail when titles or translations are longer.', 'Try narrow screens, large text settings and realistic content lengths. Flexible grids and sensible line wrapping usually hold up better than fixed widths and clipped text.'],
                ['Protecting a contact form from spam', 'A good spam strategy should reduce abuse without making genuine messages difficult to send.', 'Start with server-side validation, rate limits and sensible logging. Add a challenge only when the volume justifies it, and provide an accessible route for people who cannot complete it.'],
                ['Plan a safe website deployment', 'A repeatable release process reduces surprises when code reaches a live site.', 'Run the checks your team relies on, back up important data and understand how to roll back. After release, verify the key user journeys and watch error reports for regressions.'],
            ],
            'Business' => [
                ['Interview customers before building a new service', 'A short conversation can reveal what people already do to solve a problem and where it becomes difficult.', 'Ask about recent experiences rather than hypothetical enthusiasm. Look for repeated needs across different customers, then test a small service before committing to a costly build.'],
                ['Set prices with costs and customer value in mind', 'A sustainable price has to cover delivery costs while making sense to the people who buy.', 'List direct costs, time and ongoing support before comparing competitors. Explain what is included, review actual sales and avoid treating a temporary discount as proof of long-term demand.'],
                ['Make a useful one-page business plan', 'A concise plan can clarify the customer, the offer and the next decision without becoming a paperwork exercise.', 'Write down who the service is for, how it reaches them, what it costs to deliver and what evidence would change your mind. Update the assumptions when real customer feedback arrives.'],
                ['Improve a small team’s weekly meetings', 'A meeting earns its place when people leave with decisions, owners and clear next steps.', 'Share routine updates in writing, reserve discussion time for issues that need collaboration and record actions with dates. End early when the group has resolved the agenda.'],
                ['Build customer trust through clear policies', 'Straightforward terms make it easier for customers to know what will happen after they buy.', 'Explain delivery times, cancellations and support in plain language before checkout. Keep the policy consistent with how staff actually handle requests, and review it when the service changes.'],
                ['Choose a useful measure for a new project', 'A good measure connects day-to-day activity to an outcome customers or colleagues care about.', 'Pair an outcome, such as completed bookings, with a quality check such as cancellations or support requests. Review the numbers alongside customer feedback so one metric does not distort decisions.'],
                ['Plan a realistic first year for a small business', 'A modest forecast makes cash needs and seasonal risks easier to see.', 'Estimate income and expenses month by month, then test a slower-sales scenario. Keep personal and business finances distinct and revisit the forecast as invoices and customer demand provide better evidence.'],
            ],
            'Finance' => [
                ['Build an emergency fund one step at a time', 'A cash reserve can make an unexpected repair or change in income easier to manage.', 'Start with an amount that fits the budget and set up a regular transfer if possible. Keep the money accessible and separate from everyday spending; the right target depends on household costs and circumstances.'],
                ['Read the full cost of a loan offer', 'The advertised payment does not always show how much borrowing will cost over time.', 'Check the interest rate, fees, repayment period and whether the rate can change. Compare written offers on the same borrowing amount and ask the lender to explain any term you do not understand.'],
                ['A monthly budget that leaves room for surprises', 'A useful budget reflects actual spending and includes irregular bills rather than assuming every month is identical.', 'Look at several months of transactions, group essentials and flexible costs, and set aside money for annual expenses. Adjust the plan after a month instead of treating the first draft as a test of willpower.'],
                ['Understand the basics of workplace pensions', 'Employer contributions and tax treatment can affect how much a workplace pension grows.', 'Read the scheme information, check what your employer contributes and understand the investment choices and charges. Rules differ by country and scheme, so use official guidance for decisions about your own benefits.'],
                ['Make a debt repayment plan you can sustain', 'A clear list of balances, rates and minimum payments can turn a stressful problem into manageable steps.', 'Keep up with required payments where possible, then compare the cost of prioritising higher-interest debt with other options. If repayments are becoming unmanageable, contact a reputable, independent debt advice service early.'],
                ['Compare savings accounts beyond the headline rate', 'Access rules, introductory periods and fees matter alongside the interest rate.', 'Check whether a rate is temporary, whether withdrawals are limited and how interest is paid. Review the account when the offer changes and confirm that the provider and protections are appropriate in your country.'],
                ['Set a financial goal with a clear date', 'A specific amount and timeframe make it easier to turn a distant goal into regular contributions.', 'Divide the target by the number of months available, then check whether that contribution fits your budget. If it does not, adjust the date or target rather than relying on optimistic assumptions.'],
            ],
            'Lifestyle' => [
                ['Create a morning routine that fits real life', 'A useful morning routine should make the day easier, not add another demanding checklist.', 'Choose one or two actions that help, such as preparing breakfast or reviewing the calendar. Keep a shorter version for busy mornings so the routine remains realistic when plans change.'],
                ['Make a small home feel more organised', 'A clear place for everyday items can reduce clutter without requiring a full home makeover.', 'Notice where bags, keys and mail naturally collect, then add a simple tray or shelf there. Remove items that no longer belong and try the arrangement for a week before buying more storage.'],
                ['Protect time for a hobby in a busy week', 'A hobby is easier to keep when the first step is small and the equipment is ready.', 'Put a short session in the calendar and prepare materials in advance. Treat it as time to enjoy rather than another performance target, and choose a lighter version when the week gets crowded.'],
                ['Prepare for a less stressful move', 'A moving plan becomes easier to follow when it is divided into decisions and tasks with dates.', 'Confirm the moving date, utilities and access arrangements first. Label boxes by room, keep documents and essentials together, and leave time to clean and return keys.'],
                ['Spend more intentionally on everyday purchases', 'A brief pause can help distinguish a useful purchase from a habit triggered by convenience or advertising.', 'For non-urgent items, keep a short list and revisit it later. Compare quality, repair options and total cost, while leaving room in the plan for things that bring genuine enjoyment.'],
                ['Make shared household tasks fairer', 'A visible plan can prevent routine chores from quietly falling to one person.', 'List recurring tasks, agree on what “done” means and divide work around everyone’s schedule. Review the arrangement together; fairness may mean balancing time and effort rather than assigning identical chores.'],
                ['Create a simple evening wind-down', 'A predictable transition can help separate work and home life at the end of a long day.', 'Choose a gentle signal such as closing the laptop, preparing tomorrow’s bag or reading for a few minutes. Keep the routine flexible and seek professional advice if sleep problems persist.'],
            ],
            'Travel' => [
                ['Plan a relaxed first day in a new city', 'A light schedule leaves room to recover from travel and get oriented.', 'Choose one nearby activity, check local transport and save the address of your accommodation offline. Keep essential documents secure and avoid booking non-refundable plans that depend on a tight arrival connection.'],
                ['Pack for a weekend with a smaller bag', 'A short packing list helps avoid carrying items that will never leave the suitcase.', 'Check the forecast and planned activities, then choose clothes that work in more than one outfit. Keep medication, chargers and travel documents easy to reach, and check airline size rules before leaving home.'],
                ['Use public transport confidently while travelling', 'A little preparation can make buses and trains easier to use in an unfamiliar place.', 'Download the official route map or app, learn how tickets are validated and allow extra time for the first trip. Have a backup route and use well-lit, staffed stops when travelling late.'],
                ['Find local food without overplanning', 'Markets and neighbourhood cafés can offer a sense of place as well as a good meal.', 'Ask accommodation hosts or local visitor centres for current suggestions, check opening days and note dietary needs before ordering. Keep a flexible backup nearby in case a popular place is full.'],
                ['Travel more comfortably on a long train journey', 'A few practical choices can make several hours on a train less tiring.', 'Bring water, a light layer and anything needed to pass the time. Check seat reservations and station changes in advance, and keep valuables close when leaving your seat.'],
                ['Make a responsible wildlife-watching trip', 'Good wildlife tourism gives animals space and supports local conservation.', 'Choose guides who follow local rules, keep a respectful distance and never promise guaranteed sightings. Avoid feeding or touching wild animals, and ask where the trip fees go.'],
                ['Keep travel plans flexible when weather changes', 'A backup activity can save a day when outdoor plans are disrupted.', 'Check local forecasts and transport updates, then identify a museum, covered market or café area nearby. Follow local safety advice and confirm cancellation terms before changing paid bookings.'],
            ],
            'Food' => [
                ['A weeknight vegetable soup from what is on hand', 'Soup is a flexible way to use vegetables before they go soft and make a satisfying meal.', 'Soften onion in a little oil, add chopped vegetables and stock, then simmer until tender. Blend part of the pot for body, season gradually and refrigerate leftovers promptly.'],
                ['How to cook rice consistently on the stovetop', 'A measured ratio, gentle heat and a short rest make rice more predictable.', 'Rinse the rice if the variety benefits from it, use the packet’s water guidance and bring the pan to a gentle simmer. Keep the lid on while it cooks, then rest it off the heat before fluffing.'],
                ['Build a balanced lunch from pantry staples', 'Beans, grains and vegetables can make a filling lunch without a complicated recipe.', 'Combine a cooked grain with beans or lentils, add crisp or roasted vegetables and finish with a dressing. Keep wet ingredients separate until serving so leftovers stay appealing.'],
                ['Store fresh herbs so they last longer', 'Different herbs keep best when their leaves are protected from excess moisture or wilting.', 'Remove damaged leaves, dry herbs well and store them in a container with a paper towel in the refrigerator. Tender bunches can also sit in a glass of water, loosely covered, if your kitchen is cool.'],
                ['Make a simple tomato sauce taste fuller', 'A few minutes of cooking and careful seasoning can bring out the flavour of canned tomatoes.', 'Soften garlic gently in olive oil, add tomatoes and simmer until the sauce thickens. Taste before adding salt, and balance sharpness with time or a small amount of sweetness rather than a heavy hand.'],
                ['Plan meals to waste less food', 'A short inventory before shopping can prevent forgotten ingredients from being bought twice.', 'Check the fridge and cupboards, plan a few meals around what needs using and freeze suitable portions. Store leftovers in dated containers and follow local food safety guidance for storage times.'],
                ['Bake better cookies by measuring carefully', 'Consistent measurements and oven temperature help cookies bake the same way from one batch to the next.', 'Measure flour without packing it into the cup, use room-temperature ingredients when the recipe calls for them and leave space between portions. Let the tray cool between batches for more even results.'],
            ],
            'Health & Fitness' => [
                ['Start a walking habit at a comfortable pace', 'A regular walk can be easier to maintain when it begins with a route and pace that feel manageable.', 'Choose a convenient time, wear comfortable shoes and start with a distance you can repeat. Increase duration gradually, and speak with a health professional if activity causes unusual pain or breathlessness.'],
                ['Strength training for everyday activities', 'Basic strength exercises can support tasks such as carrying shopping and climbing stairs.', 'Begin with controlled movements using a comfortable resistance, and learn the technique before adding weight. Rest between sessions and seek qualified guidance if you have an injury or health condition.'],
                ['Build a better desk-break routine', 'Short movement breaks can interrupt long stretches of sitting during desk work.', 'Pair a break with an existing cue, such as finishing a call, and stand, stretch or walk briefly. Adjust the plan to your workspace and any guidance from your clinician.'],
                ['Make hydration part of a normal day', 'Keeping water within reach can make drinking regularly easier for many people.', 'Use thirst, activity and weather as practical cues rather than relying on a rigid target. Some medical conditions require specific fluid advice, so follow your healthcare professional’s recommendations.'],
                ['Prepare for a first visit to the gym', 'A simple plan can make a new gym feel less intimidating.', 'Choose a few familiar movements, ask staff how to adjust equipment and begin at a comfortable effort. You do not need to use every machine; consistency and safe technique matter more than a complicated routine.'],
                ['Recover well after a demanding workout', 'Rest, food and sleep all contribute to how the body feels after exercise.', 'Cool down gently, drink according to thirst and eat a normal balanced meal. Allow time between hard sessions, and get medical advice for severe pain, faintness or symptoms that concern you.'],
                ['Find a form of exercise you actually enjoy', 'People are more likely to keep moving when an activity suits their interests and daily routine.', 'Try different options such as dancing, cycling, swimming or a walking group. Focus on how it fits your life, then set a modest schedule that can survive a busy week.'],
            ],
            'Entertainment' => [
                ['Host a relaxed film night at home', 'A good film night is more about an inviting atmosphere than an elaborate setup.', 'Agree on a few choices ahead of time, check that everyone can access the film and prepare snacks that fit the group. Keep the start time realistic and let people suggest a short break.'],
                ['How to choose your next book from the library', 'A librarian’s recommendation and a short sample can be better guides than a long bestseller list.', 'Browse a subject you already enjoy, read the opening pages and check the return date. If a book is not holding your attention, returning it and choosing another is part of using the library well.'],
                ['Make a shared playlist for a road trip', 'A collaborative playlist gives everyone a chance to contribute to a long drive.', 'Invite travellers to add a small number of songs and download the list for offline playback. Keep volume low enough for conversation and let the driver focus on the road.'],
                ['Choose a board game for mixed ages', 'The best group game is one that people can learn quickly and enjoy at different experience levels.', 'Check the playing time, player count and reading demands before opening the box. A short practice round can help newcomers understand the rules without feeling put on the spot.'],
                ['Explore a local theatre on a budget', 'Community theatres and smaller venues often have lower-cost performances and a close-up view of local talent.', 'Look for student, preview or weekday tickets, and confirm what the ticket price includes. Arrive with time to find your seat and check access information if anyone in the group needs it.'],
                ['Start a family game archive', 'A simple record of favourite games can make future gatherings easier to plan.', 'Note the player count, approximate length and rules that worked well for your group. Keep the list shared so anyone can suggest a game and bring the right pieces.'],
            ],
            'Science' => [
                ['What a local weather forecast can and cannot tell you', 'Forecasts estimate likely conditions over an area, so uncertainty grows at smaller scales and further into the future.', 'Check the issue time, location and probability language before making plans. For hazardous weather, follow official local alerts rather than relying on a single app icon.'],
                ['How scientists use control groups', 'A comparison group helps researchers estimate whether an intervention made a difference.', 'Researchers try to keep other conditions similar between groups and measure outcomes consistently. The design still has limits, so a single study should be read alongside its methods and the wider evidence.'],
                ['Why urban trees help neighbourhoods', 'Street trees can provide shade, support habitat and soften the effects of hot weather.', 'Their benefits depend on species, maintenance and available space. Cities need to plan for roots, water and long-term care so new plantings can survive and serve the community.'],
                ['The science of keeping food cold', 'Lower temperatures slow the growth of many microbes, which is why prompt refrigeration matters.', 'Use a refrigerator thermometer, avoid leaving perishable food out for long periods and keep raw items separate from ready-to-eat foods. Follow local food safety advice when in doubt.'],
                ['Read a headline about a new study carefully', 'A headline rarely captures the sample size, methods and uncertainty behind a research result.', 'Look for whether the research involved people, animals or laboratory samples and whether it shows association or cause. A press release is a starting point, not a substitute for the study and independent context.'],
                ['Why the Moon appears to change shape', 'The Moon’s phases come from how much of its sunlit half is visible from Earth.', 'The cycle takes about a month, and the Moon rises at different times through it. A clear evening and a simple phase calendar are enough to begin following the pattern.'],
            ],
            'News' => [
                ['How to check a claim before sharing it', 'A brief verification step can stop an old image or misleading caption from spreading.', 'Find the original source, check the date and look for confirmation from reputable reporting or official records. Read beyond the headline and be cautious when a post urges immediate sharing.'],
                ['Understanding the difference between news and analysis', 'News reporting describes verified developments, while analysis explains what they may mean and why.', 'Check the article label, author and evidence offered for its conclusions. Strong analysis makes its reasoning visible and separates confirmed facts from interpretation.'],
                ['Follow local government decisions that affect daily life', 'Council meetings and public notices can explain upcoming changes to streets, services and neighbourhoods.', 'Use the official agenda to find the relevant meeting, then compare it with local reporting for context. Note consultation deadlines and check whether a proposal is final or still open for feedback.'],
                ['Read election polling with the right context', 'A poll is a snapshot with uncertainty, not a forecast of the final result.', 'Check when interviews took place, who was surveyed and how large the sample was. Trends across several well-designed polls are usually more informative than a single dramatic number.'],
                ['What to look for in a breaking-news update', 'Early reports can change as journalists confirm details from multiple sources.', 'Check the update time and whether a claim is attributed to named sources or official statements. Wait for corroboration before repeating casualty figures or unverified explanations.'],
                ['Find trustworthy public-service announcements', 'Official information can be essential during a disruption, but impersonation and outdated posts create confusion.', 'Follow links from the relevant agency’s known website, check the date and compare instructions with local authorities. Be wary of messages asking for payment or personal details through an unexpected link.'],
            ],
            'Opinion' => [
                ['Public libraries deserve a place in every neighbourhood', 'Libraries provide shared space, reliable information and services that are difficult to replace one household at a time.', 'Their value is visible in quiet study areas, children’s programmes and help using public services. Local decisions should consider who depends on these spaces, not only the number of books borrowed.'],
                ['Cities should make short trips safer to walk', 'A safe pavement and crossing can make nearby errands possible for people who do not drive.', 'Continuous footpaths, slower traffic near schools and well-maintained crossings are practical starting points. Residents should be involved so changes address the routes people actually use.'],
                ['Repair skills belong in modern education', 'Knowing how to mend a loose button or assess a broken appliance builds confidence and reduces avoidable waste.', 'Schools and community workshops can teach safe, basic repairs alongside digital skills. The aim is not to replace specialists, but to help people understand what can be fixed and when expert help is needed.'],
                ['A four-day workweek needs careful design', 'Fewer working days can improve focus for some teams, but the same workload compressed into less time may create new pressure.', 'Employers should measure service quality, workload and employee wellbeing during a trial. A successful change needs realistic staffing and clear expectations for customers and colleagues.'],
                ['Local news is community infrastructure', 'Reporting on schools, transport and council decisions helps residents understand changes close to home.', 'A healthy local news service needs time to verify claims and explain consequences. Readers can support it by subscribing where possible and sharing corrections with evidence when they spot an error.'],
                ['Parks should welcome different kinds of use', 'A good public park can serve people seeking play, exercise, quiet and contact with nature.', 'Thoughtful design can balance these needs through clear paths, seating and protected natural areas. Communities should be asked how they use a park before major changes are made.'],
            ],
            'Personal Development' => [
                ['Learn a new skill in short, regular sessions', 'Frequent practice makes a large learning goal feel more manageable than waiting for a free weekend.', 'Choose one small task for each session, keep notes about what was difficult and revisit earlier material. A missed day is a reason to restart, not evidence that the whole plan has failed.'],
                ['Make goals easier to act on', 'A goal becomes more useful when it includes a next action that fits into an ordinary day.', 'Replace a vague intention with a specific step, such as drafting one page after lunch. Review progress weekly and change the plan when the original schedule proves unrealistic.'],
                ['Use a weekly review to reduce mental clutter', 'A short review can help move loose tasks out of memory and into a reliable plan.', 'List open commitments, choose the few that matter most and decide when to handle them. Leave some unplanned time for interruptions instead of filling every available hour.'],
                ['Build confidence through deliberate practice', 'Confidence often grows after repeated experience with a task, especially when feedback is specific.', 'Break the task into parts, practise the hardest section and ask a trusted person for concrete observations. Notice improvement over time rather than expecting every attempt to feel comfortable.'],
                ['Set boundaries around after-hours messages', 'Clear expectations can protect personal time while still making urgent support possible.', 'Agree with colleagues how true emergencies are handled and when routine messages can wait. Use available notification settings, and revisit the boundary if role responsibilities change.'],
                ['Keep a reading habit when time is limited', 'A few pages during a regular transition can make reading part of the week.', 'Keep a book where you normally pause, choose material you are curious about and use a library if cost is a barrier. Short sessions count; there is no need to turn every hobby into a streak.'],
                ['Reflect on a difficult conversation', 'A calm review can help identify what to keep and what to change next time.', 'Write down what you wanted to communicate, what you heard and where the conversation shifted. Focus on one practical improvement, such as asking a question before offering a solution.'],
            ],
            'Culture' => [
                ['Preserve family stories with a simple audio recording', 'A short conversation can capture memories in a speaker’s own words for future generations.', 'Ask permission, choose a quiet room and let the person guide the story. Save a copy in a second place and note names, dates and locations while they are still clear.'],
                ['Why community festivals matter to local identity', 'A neighbourhood festival can bring generations together around food, music and shared history.', 'The strongest events make room for residents to shape the programme and tell their own stories. Accessible venues and fair payment for performers help the celebration include more of the community.'],
                ['Learn the story behind a historic street', 'Everyday buildings can reveal how a town changed through work, migration and transport.', 'Compare old maps with the present street, look for local archives and ask a historical society about sources. Treat family memories as valuable clues while checking dates against records.'],
                ['Keep a community garden welcoming', 'A shared garden works best when expectations and access are clear to everyone who uses it.', 'Agree on watering, tools and paths before the busy season begins. Invite new neighbours to a low-pressure task and make sure the rules do not depend on insider knowledge.'],
                ['Explore a museum through one object', 'Focusing on a single object can make a large exhibition easier to understand.', 'Read its label, notice its materials and ask who made or used it. Consider whose perspective may be missing, then look for related objects or oral histories elsewhere in the collection.'],
                ['Celebrate a cultural tradition with curiosity', 'Learning about a tradition is more respectful when it starts with the people who practise it.', 'Ask hosts what participation means, listen to the context they share and follow their guidance on photography or clothing. Avoid assuming that one person can represent an entire community.'],
            ],
        ];

        $index = 0;

        foreach ($articles as $categoryName => $categoryArticles) {
            $category = $categories->get($categoryName);

            if (! $category) {
                continue;
            }

            foreach ($categoryArticles as [$title, $excerpt, $guidance]) {
                $index++;
                $slug = Str::slug($title);
                $subheading = $guidance;
                $content = '<p>' . e($excerpt) . '</p>'
                    . '<h2>Start with what matters</h2><p>' . e($guidance) . '</p>'
                    . '<h2>Make it work for you</h2><p>Keep the first step manageable, use information from reliable sources and adjust the approach to your own circumstances. Small changes are easier to review and improve than a plan that depends on everything going perfectly.</p>';

                Post::create([
                    'title' => $title,
                    'slug' => $slug,
                    'subheading' => $subheading,
                    'excerpt' => $excerpt,
                    'status' => 'live',
                    'allow_comments' => 'allow',
                    'featured_image' => $images->isEmpty()
                        ? 'images/default-post.jpg'
                        : $images->get(($index - 1) % $images->count())->path,
                    'featured_image_caption' => $title,
                    'content' => $content,
                    'meta_title' => $title,
                    'meta_description' => Str::limit($excerpt, 155, ''),
                    'user_id' => $authors->get(($index - 1) % $authors->count())->id,
                    'category_id' => $category->id,
                    'published_at' => now()->subDays($index),
                ]);
            }
        }
    }
}

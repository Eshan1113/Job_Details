

<footer class="bg-blue-600 text-white p-6 mt-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between">
        <!-- Technologies Section -->
        <div class="mb-4 md:mb-0">
            <h3 class="text-lg font-bold mb-2">Technologies (2025)</h3>
            <ul class="list-disc pl-6 space-y-1">
                <?php foreach ($technologies as $tech): ?>
                    <li><?php echo htmlspecialchars($tech); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Departments Section -->
        <div class="mb-4 md:mb-0">
            <h3 class="text-lg font-bold mb-2">Departments (2025)</h3>
            <ul class="list-disc pl-6 space-y-1">
                <?php foreach ($departments as $dept): ?>
                    <li><?php echo htmlspecialchars($dept); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Year Section -->
        <div>
            <h3 class="text-lg font-bold mb-2">Year</h3>
            <p class="text-sm">Copyright &copy; <?php echo date("Y"); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

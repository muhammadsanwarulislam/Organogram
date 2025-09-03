<template>
    <div class="min-h-screen bg-gray-50 flex flex-col">
        <div>
            <slot name="header"></slot>
        </div>

        <main class="flex-grow">
            <slot></slot>
        </main>
        
        <div>
            <slot name="footer"></slot>
        </div>
    </div>
</template>
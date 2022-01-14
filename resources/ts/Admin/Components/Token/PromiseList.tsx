import * as React from 'react';
import PromiseCard from './PromiseCard';
import ResourceList from '../../Components/ResourceList';

interface PromiseListProps {
	promises: Array<any>;
}

export default function PromiseList( props: PromiseListProps ) {
	return (
		<ResourceList
			items={ props.promises }
			component={ PromiseCard }
			itemProp="promise"
			notFoundLabel="promises"
		/>
	);
}

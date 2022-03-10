import * as React from 'react';
import PromiseCard from './PromiseCard';
import ResourceList from '../../Components/ResourceList';
import PromiseCollectionInterface from '../../../Interfaces/Collections/Token/PromiseCollectionInterface';

interface PromiseListProps {
	promises: PromiseCollectionInterface;
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
